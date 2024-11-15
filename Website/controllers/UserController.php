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

    public function home(): void
    {
        echo $this->twig->render($this->vues['home']);
    }

    public function account(int $id): void
    {
        echo $this->twig->render($this->vues['account'], ['userId' => $id]);
    }

    public function settings(int $id): void
    {
        echo $this->twig->render($this->vues['settings'], ['userId' => $id]);
    }

    public function login(): void
    {
        echo $this->twig->render($this->vues['login']);
    }
    public function register(): void
    {
        echo $this->twig->render($this->vues['register']);
    }
     public function gamemode(): void
    {
        echo $this->twig->render($this->vues['gamemode']);
    }

    public function logout(): void
    {
        session_destroy();
        header("Location: /");
        exit;
    }
}
