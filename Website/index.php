<?php

require_once(__DIR__ . '/usages/Config.php');
require_once(__DIR__ . '/usages/Config_DB.php');
var_dump(__DIR__);
echo 0;
require __DIR__ . '/vendor/autoload.php';
echo 1;
//twig
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig   = new \Twig\Environment($loader, [
    'cache' => false,
]);
echo 3;
$controller = new controllers\FrontController();