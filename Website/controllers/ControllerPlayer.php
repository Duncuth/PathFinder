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

    public function gamemode() : void
    {
        echo $this->twig->render($this->vues["gamemode"]);
    }   

    public function account() : void
    {
        echo $this->twig->render($this->vues["account"]);
    }



    public function registerPlayer(): void
    {
        try {
            // Récupération des données du formulaire
            $username = $_POST['username'] ?? null;
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;

            // Validation des champs
            if (empty($username) || empty($email) || empty($password)) {
                $_SESSION['error'] = "Tous les champs sont requis.";
                echo $this->twig->render($this->vues["register"], [
                    'error' => $_SESSION['error'] ?? null
                ]);
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Adresse email invalide.";
                echo $this->twig->render($this->vues["register"], [
                    'error' => $_SESSION['error'] ?? null
                ]);
                return;
            }

            // Préparation des données pour le modèle
            $playerData = [
                'username' => $username,
                'email' => $email,
                'password' => $password, // Hachage géré dans le modèle
                'avatar_url' => null,
                'is_moderator' => false
            ];
            // Appel au modèle pour ajouter le joueur
            $modelPlayer = new \models\PlayerModel();
            $modelPlayer->addPlayer($playerData);

            // Redirection avec message de succès
            $_SESSION['success'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
            echo $this->twig->render($this->vues["login"]);
        } catch (Exception $e) {
            $_SESSION['error'] = "Une erreur est survenue lors de l'inscription.";
            echo $this->twig->render($this->vues["register"], [
                'error' => $_SESSION['error'] ?? null
            ]);
        }
    }


}