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
            $router->map('GET', '/', 'ControllerPlayer#home'); // Route for the home page
            $router->map('GET', '/error', 'ControllerPlayer#error');  // Route for the error page
            $router->map('GET|POST', '/[a:action]', 'ControllerPlayer'); // Route for the deconnexion page
            $router->map('POST', '/login/[a:action]', 'ControllerPlayer');
            $router->map('GET|POST', '/admin/[a:action]', 'AdministratorController');
            $router->map('POST', '/admin/administrators/[a:action]', 'AdministratorController');
            // Match the current request
            $match = $router->match();

            if (!$match) {
                echo "404 azi"; // Redirect to a 404 error page
                die;
            }
            
            if ($match) {
                $controller = $match['target'];
                if (str_contains($controller, "#")) {
                    list($controller, $action) = explode("#", $controller);
                } else {
                    $action = $match['params']['action'] ?? null;
                    $id = $match['params']['id'] ?? null;
                }
                $controllerClass = "\\controllers\\" . $controller;
                $controllerInstance = new $controllerClass();
                if (is_callable(array($controllerInstance, $action))) {
                    call_user_func_array(array($controllerInstance, $action), array($match['params']));
                }
            }
        } catch (Exception $e) {
            header("Location:" . $vues["error"]);
        }
    }
}