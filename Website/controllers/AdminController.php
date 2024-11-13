<?php

namespace Website\controllers;

use Twig\Environment;
use Exception;

class AdminController
{
    private Environment $twig;
    private array $vues;

    public function __construct(array $vues, Environment $twig)
    {
        $this->twig = $twig;
        $this->vues = $vues;
    }

    // Dashboard overview
    public function dashboard(): void
    {
        echo $this->twig->render($this->vues['dashboard']);
    }

    // Manage users (admin-only)
    public function manageUsers(): void
    {
        // Fetch users data and render management page
        echo $this->twig->render($this->vues['manageUsers']);
    }

    // Manage site content (admin-only)
    public function manageContent(): void
    {
        echo $this->twig->render($this->vues['manageContent']);
    }

    // Admin settings
    public function settings(): void
    {
        echo $this->twig->render($this->vues['adminSettings']);
    }
}