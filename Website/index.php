<?php

require_once(__DIR__ . '/usages/Config.php');
require_once(__DIR__ . '/usages/Config_DB.php');
require __DIR__ . '/vendor/autoload.php';
//twig
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig   = new \Twig\Environment($loader, [
    'cache' => false,
]);

$controller = new controllers\FrontController($twig);