<?php
require_once('../../projekt-4-app.php');

$userStmt = $pdo->prepare("SELECT * FROM Users");
$userStmt->execute();
$userResult = $userStmt->fetchAll();

$view["users"] = $userResult;
$view["namn"] = "Simon";

//printAndExit($view);

$twig->display('example.html.twig', $view);