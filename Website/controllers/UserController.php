<?php

namespace Website\controllers;

use Twig\Environment;
use Exception;

class UserController
{
    private Environment $twig;
    private array $vues;

    public function __construct(array $vues, Environment $twig)
    {
        $this->twig = $twig;
        $this->vues = $vues;
    }

    // Home page
    public function home(): void
    {
        echo $this->twig->render($this->vues['home']);
    }

    // Display user profile
    public function profile(int $id): void
    {
        // Fetch user data based on $id and render profile page
        echo $this->twig->render($this->vues['profile'], ['userId' => $id]);
    }

    // Update user settings
    public function settings(int $id): void
    {
        // Fetch settings data based on $id
        echo $this->twig->render($this->vues['settings'], ['userId' => $id]);
    }

    // Login page
    public function login(): void
    {
        echo $this->twig->render($this->vues['login']);
    }

    // Logout action
    public function logout(): void
    {
        // Perform logout logic (e.g., session_destroy())
        session_destroy();
        header("Location: /");
        exit;
    }
}
