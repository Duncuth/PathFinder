<?php

namespace Website\controllers;

use AltoRouter;
use \Website\controllers\UserController;
use \Exception;

class FrontController
{
    function __construct()
    {
        global $vues;

        try {
            // Initialize AltoRouter
            $router = new AltoRouter();

            // Basic routes
            $router->map('GET', '/', 'UserController#home');
            $router->map('GET', '/error', 'UserController#error');

            $router->map('GET|POST', '/[a:action]', 'UserController');
            //$router->map('GET', '/admin', 'ControllerAdminAdministrators');
            $router->map('POST', '/login/[a:action]', 'UserController');

            // Match the current request
            $match = $router->match();

            if (!$match) {
                echo $this->render($vues['error']);
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
                $controller = new ("\\Website\\controllers\\" . $controller)();
                if (is_callable(array($controller, $action))) {
                    call_user_func_array(array($controller,$action), array($match['params']));
                }
            }
        } catch (Exception $e) {
            header("Location:" . $vues["erreur"]);
        }
    }
}
