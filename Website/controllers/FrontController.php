<?php

namespace controllers;

use Exception;
use AltoRouter;

class FrontController
{
    private $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
        try {
            $router = new AltoRouter();
            $basePath = '';
            $router->setBasePath($basePath);
            $twig->addGlobal('basePath', $basePath);

            $router->map('GET', '/', 'ControllerPlayer#home');
            $router->map('GET', '/error', 'ControllerPlayer#error');
            $router->map('GET|POST', '/[a:action]', 'ControllerPlayer');
            $router->map('POST', '/login/[a:action]', 'ControllerPlayer');
            $router->map('GET|POST', '/admin/[a:action]', 'AdministratorController');
            $router->map('POST', '/admin/administrators/[a:action]', 'AdministratorController');
            $router->map('POST', '/admin/players/[a:action]', 'AdministratorController');
            $router->map('GET', '/admin/players/[a:action]/[i:id]', 'AdministratorController');
            $router->map('GET', '/play/[i:id]', 'ControllerPlayer#play');


            $match = $router->match();

            if (!$match) {
                $this->render404();
                return;
            }

            $this->dispatch($match);
        } catch (Exception $e) {
            $this->renderError($e);
        }
    }

    private function render404()
    {
        header("HTTP/1.0 404 Not Found");
        echo $this->twig->render('404.twig');
        die;
    }

    private function renderError($exception)
    {
        header("HTTP/1.0 500 Internal Server Error");
        echo $this->twig->render('error.twig', [
            'message' => $exception->getMessage(),
        ]);
        die;
    }

    private function dispatch($match)
    {
        $controller = $match['target'];

        if (str_contains($controller, "#")) {
            list($controller, $action) = explode("#", $controller);
        } else {
            $action = $match['params']['action'] ?? null;
        }

        $controllerClass = "\\controllers\\" . $controller;

        if (!class_exists($controllerClass)) {
            throw new Exception("Controller '$controllerClass' does not exist.");
        }

        $controllerInstance = new $controllerClass($this->twig);

        if (is_callable([$controllerInstance, $action])) {
            call_user_func_array([$controllerInstance, $action], [$match['params']]);
        } else {
            throw new Exception("Action '$action' is not callable in controller '$controllerClass'.");
        }
    }
}
