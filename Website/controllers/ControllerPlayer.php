<?php

namespace controllers;

use classes\PlayerStats;
use Exception;
use models\PlayerModel;

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
        $liste = [
            new PlayerStats(1, 1, 10, 5, 100),
            new PlayerStats(2, 2, 20, 10, 200),
            // Add more PlayerStats instances as needed
        ];
        echo $this->twig->render($this->vues["leaderboard"], [
            "players" => $liste
        ]);
    }   

    public function joinGame() : void
    {
        echo $this->twig->render($this->vues["joinGame"]);
    }

    public function gamemode() : void
    {
        echo $this->twig->render($this->vues["gamemode"]);
    }   

    public function account() : void
    {
        echo $this->twig->render($this->vues["account"]);
    }
}