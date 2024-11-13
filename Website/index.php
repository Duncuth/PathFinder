<?php
require __DIR__ . '/vendor/autoload.php';

use Twig\TwigFunction;
use Website\controllers\FrontController;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Set up Twig
$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader, [
    'cache' => false,  // Set to false for development; set a path for production caching
    'debug' => true,
]);

$vues = [
    'account' => 'account.twig',
    'error' => 'error.twig',
    'gamemode' => 'gamemode.twig',
    'home' => 'home.twig',
    'leaderboard' => 'leaderboard.twig',
    'login' => 'login.twig',
    'register' => 'register.twig',
    'settings' => 'settings.twig',
];

$router = new AltoRouter();

try {
    $controller = new FrontController($vues, $twig, $router);
    $controller->handleRequest();
} catch (Exception $e) {
    echo $twig->render($vues['error'], ['errorMessage' => $e->getMessage()]);
}
