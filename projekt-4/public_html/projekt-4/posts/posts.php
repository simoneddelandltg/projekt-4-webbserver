<?php
require_once('../../../projekt-4-app.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$postStmt = $pdo->prepare("SELECT * FROM Posts JOIN Users ON Posts.User = Users.UserId WHERE username = :username");
$postStmt->execute([
    "username" => $_SESSION['username']
]);
$postResult = $postStmt->fetchAll();


$view["posts"] = $postResult;

$twig->display('posts/posts.html.twig', $view);