<?php

namespace controllers;

use Exception;

/**
 * Class ControllerPlayer
 *
 * Manages player-related actions such as home, error, login, register, settings, leaderboard, joinGame, gamemode, account, registerPlayer, and loginPlayer.
 */
class ControllerPlayer
{
    /**
     * @var array $vues The views to be rendered.
     */
    private $vues;

    /**
     * @var \Twig\Environment $twig The Twig environment for rendering views.
     */
    private $twig;

    /**
     * ControllerPlayer constructor.
     *
     * Initializes the views and Twig environment.
     */
    public function __construct()
    {
        global $vues, $twig;
        session_start();
        try {
            $this->twig = $twig;
            $this->vues = $vues;
        } catch (Exception $e) {
            // Handle exception
        }
    }

    /**
     * Render the home view.
     *
     * @return void
     */
    public function home() : void
    {
        echo $this->twig->render($this->vues["home"],
            [
                'isPlayer' => isset($_SESSION['idPlayerConnected']),
                'username' => $_SESSION['username'] ?? null
            ]
        );
    }

    /**
     * Render the error view.
     *
     * @return void
     */
    public function error() : void
    {
        echo $this->twig->render($this->vues["error"]);
    }

    /**
     * Render the login view.
     *
     * @return void
     */
    public function login() : void
    {
        echo $this->twig->render($this->vues["login"]);
    }

    /**
     * Render the register view.
     *
     * @return void
     */
    public function register() : void
    {
        echo $this->twig->render($this->vues["register"]);
    }

    /**
     * Render the settings view.
     *
     * @return void
     */
    public function settings() : void
    {
        echo $this->twig->render($this->vues["settings"]);
    }

    /**
     * Render the leaderboard view.
     *
     * @return void
     */
    public function leaderboard() : void
    {
        echo $this->twig->render($this->vues["leaderboard"]);
    }

    /**
     * Render the joinGame view.
     *
     * @return void
     */
    public function joinGame() : void
    {
        echo $this->twig->render($this->vues["joinGame"]);
    }

    /**
     * Render the gamemode view.
     *
     * @return void
     */
    public function gamemode() : void
    {
        echo $this->twig->render($this->vues["gamemode"]);
    }

    /**
     * Render the account view.
     *
     * @return void
     */
    public function account() : void
    {
        echo $this->twig->render($this->vues["account"]);
    }

    /**
     * Register a new player.
     *
     * @return void
     */
    public function registerPlayer(): void
    {
        try {
            // Retrieve form data
            $username = $_POST['username'] ?? null;
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;

            // Validate fields
            if (empty($username) || empty($email) || empty($password)) {
                $_SESSION['error'] = "Tous les champs sont requis.";
                echo $this->twig->render($this->vues["register"], [
                    'error' => $_SESSION['error']
                ]);
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Adresse email invalide.";
                echo $this->twig->render($this->vues["register"], [
                    'error' => $_SESSION['error']
                ]);
                return;
            }

            // Prepare data for the model
            $playerData = [
                'username' => $username,
                'email' => $email,
                'password' => $password, // Hashing handled in the model
                'avatar_url' => null,
                'is_moderator' => false
            ];
            // Call the model to add the player
            $modelPlayer = new \models\PlayerModel();
            $modelPlayer->addPlayer($playerData);

            // Redirect with success message
            $_SESSION['success'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
            echo $this->twig->render($this->vues["login"], [
                'success' => $_SESSION['success']
            ]);
        } catch (Exception $e) {
            $_SESSION['error'] = "Une erreur est survenue lors de l'inscription.";
            echo $this->twig->render($this->vues["register"], [
                'error' => $_SESSION['error']
            ]);
        }
    }

    /**
     * Log in a player.
     *
     * @return void
     */
    public function loginPlayer(): void
    {
        try {
            // Retrieve POST data
            $username = $_POST['username'] ?? null;
            $password = $_POST['password'] ?? null;

            // Validate fields
            if (empty($username) || empty($password)) {
                $_SESSION['error'] = "Tous les champs sont requis.";
                echo $this->twig->render($this->vues["login"], [
                    'error' => $_SESSION['error']
                ]);
                unset($_SESSION['error']);
                return;
            }

            // Prepare data for verification
            $playerData = [
                'username' => $username,
                'password' => $password
            ];

            // Load the model and verify
            $modelPlayer = new \models\PlayerModel();
            $playerId = $modelPlayer->verifyPlayer($playerData);

            if (!$playerId) {
                // Login failed
                $_SESSION['error'] = "Pseudo ou mot de passe incorrect.";
                echo $this->twig->render($this->vues["login"], [
                    'error' => $_SESSION['error']
                ]);
                unset($_SESSION['error']);
                return;
            }

            // Login successful: Store user in session
            $_SESSION['idPlayerConnected'] = $playerId;
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "Connexion réussie. Bienvenue, " . $username . "!";

            // Render home page with logged-in state
            echo $this->twig->render($this->vues["home"], [
                'isPlayer' => true,
                'username' => $username,
                'success' => $_SESSION['success']
            ]);

        } catch (Exception $e) {
            // Handle general errors
            $_SESSION['error'] = "Une erreur inattendue est survenue.";
            echo $this->twig->render($this->vues["login"], [
                'error' => $_SESSION['error']
            ]);
            unset($_SESSION['error']);
        }
    }
}