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

        // Define routes
        $this->initializeRoutes();
    }

    private function initializeRoutes(): void
    {
        $this->router->map('GET', '/', 'ControllerPlayer#index', 'home');
        $this->router->map('GET', '/error', 'ControllerPlayer#error', 'error');
        $this->router->map('GET', '/gameModeChoice', 'ControllerPlayer#gameModeChoice', 'game_mode_choice');
        $this->router->map('GET', '/connexion', 'ControllerPlayer#connexion', 'connexion');
        $this->router->map('GET', '/settings', 'ControllerPlayer#settings', 'settings');
        $this->router->map('GET', '/leaderboard', 'ControllerPlayer#leaderboard', 'leaderboard');
    }

    public function handleRequest(): void
    {
        try {
            $match = $this->router->match();

            if ($match) {
                error_log("Matched route: " . json_encode($match)); // Log matched route
                list($controllerName, $action) = explode('#', $match['target']);
                $controllerClass = 'Website\\controllers\\' . $controllerName;

                if (class_exists($controllerClass) && method_exists($controllerClass, $action)) {
                    $controller = new $controllerClass($this->vues, $this->twig);
                    call_user_func_array([$controller, $action], $match['params']);
                } else {
                    error_log("Error: Cannot call $controllerClass#$action"); // Log if class/method not found
                    throw new Exception("Error: Cannot call $controllerClass#$action");
                }
            } else {
                error_log("No route matched."); // Log when no route matches
                header("HTTP/1.0 404 Not Found");
                echo $this->twig->render($this->vues['error'], ['errorMessage' => 'Page not found']);
            }
        } catch (Exception $e) {
            error_log("Exception caught in handleRequest: " . $e->getMessage()); // Log exception details
            echo $this->twig->render($this->vues['error'], ['errorMessage' => $e->getMessage()]);
        }
    }
}
