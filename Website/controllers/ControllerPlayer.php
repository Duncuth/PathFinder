<?php

namespace controllers;

use Exception;

class ControllerPlayer
{
    private $vues;
    private $twig;
    public function __construct()
    {
        global $vues, $twig;
        session_start();
        try {
            $this->twig = $twig;
            $this->vues = $vues;
        } catch (Exception $e) {

        }


    }

    public function home() : void
    {
        echo $this->twig->render($this->vues["home"]);
    }

    public function error() : void
    {
        echo $this->twig->render($this->vues["error"]);
    }

    public function login() : void
    {
        echo $this->twig->render($this->vues["login"]);
    }

    public function register() : void
    {
        echo $this->twig->render($this->vues["register"]);
    }

    public function settings() : void
    {
        echo $this->twig->render($this->vues["settings"]);
    }

    public function leaderboard() : void
    {
        echo $this->twig->render($this->vues["leaderboard"]);
    }   

    public function joinGame() : void
    {
        echo $this->twig->render($this->vues["joinGame"]);
    }

    public function adminUser() : void
    {
        echo $this->twig->render($this->vues["adminUser"]);
    }

    public function adminAdministrators() : void
    {
        echo $this->twig->render($this->vues["adminAdministrators"]);
    }

    public function gamemode() : void
    {
        echo $this->twig->render($this->vues["gamemode"]);
    }   

    public function graphManagement() : void
    {
        echo $this->twig->render($this->vues["graphManagement"]);
    }

    public function adminGraph() : void
    {
        echo $this->twig->render($this->vues["adminGraph"]);
    }

    public function account() : void
    {
        echo $this->twig->render($this->vues["account"]);
    }
}