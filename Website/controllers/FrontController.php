<?php

namespace Website\controllers;

use AltoRouter;
use Twig\Environment;
use Exception;

class FrontController
{
    private AltoRouter $router;
    private Environment $twig;
    private array $vues;

    public function __construct(array $vues, Environment $twig, AltoRouter $router)
    {
        $this->twig = $twig;
        $this->vues = $vues;
        $this->router = $router;
        $this->initializeRoutes();
        session_start();
    }

    private function initializeRoutes(): void
    {
        // General routes
        $this->router->map('GET', '/', 'UserController#home', 'home');
        $this->router->map('GET', '/error', 'UserController#error', 'error');

        // User and Admin roles handling different actions
        $this->router->map('GET|POST', '/user/[i:id]/[a:action]?', 'UserController#userAction');
        $this->router->map('GET|POST', '/admin/[a:action]?', 'AdminController#adminAction');
    }

    public function handleRequest(): void
    {
        try {
            $match = $this->router->match();

            if ($match && isset($match['target'])) {
                list($controllerName, $action) = explode('#', $match['target']);
                $controllerClass = 'Website\\controllers\\' . $controllerName;

                if ($this->hasAccess($controllerName, $action)) {
                    $this->callController($controllerClass, $action, $match['params']);
                } else {
                    echo $this->twig->render($this->vues['error'], ['errorMessage' => 'Access Denied']);
                }
            } else {
                echo $this->twig->render($this->vues['error'], ['errorMessage' => 'Page Not Found']);
            }
        } catch (Exception $e) {
            echo $this->twig->render($this->vues['error'], ['errorMessage' => $e->getMessage()]);
        }
    }

    private function hasAccess(string $controller, string $action): bool
    {
        if ($controller === 'AdminController' && !$this->isAdmin()) {
            return false;
        }
        return true;
    }

    private function isAdmin(): bool
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    /**
     * @throws Exception
     */
    private function callController(string $controllerClass, string $action, array $params): void
    {
        if (class_exists($controllerClass)) {
            $controller = new $controllerClass($this->vues, $this->twig);
            if (method_exists($controller, $action) && is_callable([$controller, $action])) {
                call_user_func_array([$controller, $action], $params);
            } else {
                throw new Exception("Method $action is not callable in $controllerClass.");
            }
        } else {
            throw new Exception("Class $controllerClass does not exist.");
        }
    }
}