<?php

namespace controllers;

use Exception;
use AltoRouter;

class FrontController
{
    function __construct()
    {
        global $vues;

        try {
            // Initialize AltoRouter
            $router = new AltoRouter();

            //$router->setBasePath('/');

            // Define routes
            $router->map('GET', '/', 'ControllerPlayer#home'); // Route pour la page d'accueil
            $router->map('GET', '/error', 'ControllerPlayer#error'); // Route pour la page d'erreur

            // Match the current request
            $match = $router->match();

            if (!$match) {
                echo "404"; // Redirige vers une page d'erreur 404
                die;
            }

            if ($match) {
                $controller = $match['target'];
                if (strpos($controller, "#") !== false) {
                    list($controller, $action) = explode("#", $controller);
                } else {
                    $action = $match['params']['action'];
                    $id = $match['params']['id'];
                }
                $controller = new ("controllers\\".$controller)();
                if (is_callable(array($controller, $action))) {
                    call_user_func_array(array($controller,    $action), array($match['params']));
                }
            }
        }catch (Exception $e) {
            header("Location:" . $vues["error"]);
        }
    }
}