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
        echo $this->twig->render($this->vues["homeDisconnected"]);
    }

    public function error() : void
    {
        echo $this->twig->render($this->vues["error"]);
    }

    public function connexion() : void
    {
        echo $this->twig->render($this->vues["connexion"]);
    }

}