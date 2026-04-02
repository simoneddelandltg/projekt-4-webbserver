<?php
require_once('../../projekt-4-app.php');

$_SESSION = [];
session_destroy();
unset($view["username"]);

$twig->display('logout.html.twig', $view);