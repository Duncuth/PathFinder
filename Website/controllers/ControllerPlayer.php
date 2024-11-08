<?php

namespace Website\controllers;

use Twig\Environment;

class ControllerPlayer
{
    private Environment $twig;
    private array $vues;

    public function __construct(array $vues, Environment $twig)
    {
        $this->twig = $twig;
        $this->vues = $vues;
    }

    // Home page method
    public function index(): void
    {
        echo $this->twig->render($this->vues['indexDisconnected']);
    }

    // Error page method
    public function error(): void
    {
        echo $this->twig->render($this->vues['error'], ['errorMessage' => 'An error occurred.']);
    }

    // Game mode choice page method
    public function gameModeChoice(): void
    {
        echo $this->twig->render($this->vues['gameModeChoice']);
    }

    // Connexion page method
    public function connexion(): void
    {
        echo $this->twig->render($this->vues['connexion']);
    }

    // Settings page method
    public function settings(): void
    {
        echo $this->twig->render($this->vues['settings']);
    }

    // Leaderboard page method
    public function leaderboard(): void
    {
        echo $this->twig->render($this->vues['leaderboard']);
    }
}
