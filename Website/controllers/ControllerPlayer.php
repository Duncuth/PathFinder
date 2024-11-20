<?php

namespace controllers;

use classes\PlayerStats;
use Exception;
use models\PlayerModel;

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

    public function adminAdministrators() : void
    {
        echo $this->twig->render($this->vues["adminAdministrators"]);
    }

    /**
     * Render the leaderboard view.
     *
     * @return void
     */
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
        if ($_SESSION["idPlayerConnected"] != null) {
            $mdPlayer = new PlayerModel();
            $player = $mdPlayer->getPlayerByID($_SESSION["idPlayerConnected"]);
            echo $this->twig->render(
                $this->vues["account"],
                [
                    'player' => $player,
                    'error' => $_SESSION["error"],
                ]
            );
            $_SESSION["error"]=null;
        } else {
            header("Location:/loginPlayer");
        }
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

    /**
     * Update the account information of a player.
     *
     * @return void
     */
    public function updateAccount(): void
    {
        try {
            // Vérifier si l'utilisateur est connecté
            if (!isset($_SESSION['idPlayerConnected'])) {
                $_SESSION['error'] = "Vous devez être connecté pour modifier votre compte.";
                echo $this->twig->render($this->vues["login"], [
                    'error' => $_SESSION['error']
                ]);
                unset($_SESSION['error'], $_SESSION['success']);
                exit;
            }

            // Récupérer les données du formulaire
            $newUsername = $_POST['username'] ?? null;
            $newEmail = $_POST['email'] ?? null;
            $newPassword = $_POST['password'] ?? null;

            $playerId = $_SESSION['idPlayerConnected'];

            // Vérifier que les données sont valides
            if (empty($newUsername) && empty($newEmail) && empty($newPassword)) {
                $_SESSION['error'] = "Aucune donnée valide à mettre à jour.";
                echo $this->twig->render($this->vues["account"], [
                    'error' => $_SESSION['error']
                ]);
                unset($_SESSION['error'], $_SESSION['success']);
                exit;
            }

            $dataToUpdate = [];

            // Validation du pseudo
            if (!empty($newUsername)) {
                $dataToUpdate['username'] = $newUsername;
            }

            // Validation de l'email
            if (!empty($newEmail)) {
                if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['error'] = "L'adresse email est invalide.";
                    echo $this->twig->render($this->vues["account"], [
                        'error' => $_SESSION['error']
                    ]);
                    unset($_SESSION['error'], $_SESSION['success']);
                    exit;
                }
                $dataToUpdate['email'] = $newEmail;
            }

            // Validation du mot de passe
            if (!empty($newPassword)) {
                $dataToUpdate['password'] = $newPassword;
            }

            // Charger le modèle
            $modelPlayer = new \models\PlayerModel();

            // Mettre à jour les informations
            $updated = $modelPlayer->updatePlayer($playerId, $dataToUpdate);

            if ($updated) {
                $_SESSION['success'] = "Votre compte a été mis à jour avec succès.";
            } else {
                $_SESSION['error'] = "Aucune modification n'a été effectuée.";
            }

            // Rediriger vers la page du compte
            echo $this->twig->render($this->vues["account"], [
                'error' => $_SESSION['error'] ?? null,
                'success' => $_SESSION['success'] ?? null
            ]);
            unset($_SESSION['error'], $_SESSION['success']);
            exit;
        } catch (Exception $e) {
            // Gestion des erreurs
            $_SESSION['error'] = "Une erreur inattendue est survenue : " . $e->getMessage();
            echo $this->twig->render($this->vues["account"], [
                'error' => $_SESSION['error']
            ]);
            unset($_SESSION['error'], $_SESSION['success']);
            exit;
        }
    }

    /**
     * Log out the current player.
     *
     * @return void
     */
    public function logout(): void
    {
        try {
            session_unset();
            session_destroy();

            // Rediriger l'utilisateur vers la page de connexion
            $_SESSION['success'] = "Vous avez été déconnecté avec succès.";
            echo $this->twig->render($this->vues["login"], [
                'success' => $_SESSION['success']
            ]);
            exit;
        } catch (Exception $e) {
            // Gestion des erreurs
            $_SESSION['error'] = "Une erreur est survenue lors de la déconnexion.";
            echo $this->twig->render($this->vues["login"], [
                'error' => $_SESSION['error']
            ]);
            exit;
        }
    }
}