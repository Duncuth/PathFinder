<?php

namespace controllers;


class ControllerPlayer
{
    private $vues;
    private $twig;
    public function __construct()
    {
        global $vues;
        $this->vues = $vues;
        global $twig;
        $this->twig = $twig;
    }

    public function home() : void
    {
        echo $this->twig->render($this->vues["homeDisconnected"]);
    }

    public function error() : void
    {
        echo $this->twig->render($this->vues["error"]);
    }

}