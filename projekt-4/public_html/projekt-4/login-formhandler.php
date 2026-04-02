<?php
require_once('../../projekt-4-app.php');

$messages = array();

// Har formuläret fyllts i?
if (!isset($_POST["username"]) || !isset($_POST["password"]) || $_POST["username"] == "" || $_POST["password"] == "") {
    $messages[] = "Formuläret är inte korrekt ifyllt!";

} else {
    // Formuläret är ifyllt. Hämta användarens hashade lösenord
    $loginStmt = $pdo->prepare("SELECT * FROM Users WHERE Username = :username");
    $loginStmt->execute([
        "username" => $_POST["username"]
    ]);
    $loginResult = $loginStmt->fetch();

    // Finns användaren?
    if ($loginResult != false) {

        // Är lösenordet rätt?
        if (password_verify($_POST["password"], $loginResult["Password"])) {

            // Lösenordet är rätt! Användaren loggas in genom att spara användarnamnet i $_SESSION
            session_regenerate_id();
            $_SESSION["username"] = $loginResult["Username"];
            $view["username"] = $loginResult["Username"];
            $messages[] = "Du loggade in som " . $loginResult["Username"];

        } else {
            // Fel lösenord
            $messages[] =  "Inloggningen misslyckades";
        }
        
    } else {
        // Användarnamnet finns inte
        $messages[] = "Inloggningen misslyckades";
    }
}

$view["messages"] = $messages;

$twig->display('login.html.twig', $view);