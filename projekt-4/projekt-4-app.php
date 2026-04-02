<?php
session_start();

// Database connection
$dsn = "sqlite:" . __DIR__ . "/projekt-4.db";

try {
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Failed to connect to the database using DSN:<br>'$dsn'<br>" . $e->getMessage();
    exit();
}

// Autoloader, behövs för Twig
spl_autoload_register(function ($classname)
{
    $dirs = [__DIR__ . '/Twig-3.22.2/'];
    foreach ($dirs as $dir) {
        $filename = $dir . str_replace('\\', '/', $classname) .'.php';
        if (file_exists($filename)) {
            require_once $filename;
            break;
        }
    }
});

// Inställningar för Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);

require_once(__DIR__ . "/projekt-4-config.php");

$function = new \Twig\TwigFunction('url', function ($path) {   
    global $base;
    return $base . $path;
});
$twig->addFunction($function);

$view = [];

if (isset($_SESSION['username'])) {
    $view["username"] = $_SESSION['username'];
}

function printAndExit($variable) {
    echo "<pre>" . print_r($variable, 1) . "</pre>";
    exit;
}