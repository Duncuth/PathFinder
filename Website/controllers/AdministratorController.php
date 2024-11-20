<?php

namespace controllers;

use \Exception;
use models\PlayerModel;
use \PDOException;
use models\AdministratorModel;

/**
 * Class AdministratorController
 *
 * This controller handles administrative actions such as managing players and administrators.
 */
class AdministratorController
{
    private $mdAdministrator;
    private $mdPlayer;
    private $twig;
    private $vues;

    /**
     * Constructor for AdministratorController.
     * Initializes models and session.
     */
    function __construct()
    {
        global $vues, $twig;
        session_start();
        try {
            $this->twig = $twig;
            $this->vues = $vues;

            $this->mdAdministrator = new AdministratorModel();
            $this->mdPlayer = new PlayerModel();
        } catch (PDOException $e) {
            // Handle PDO exceptions
        } catch (Exception $e2) {
            // Handle general exceptions
        }
    }

    /**
     * Displays the admin player management page.
     * Requires admin authentication.
     */
    public function adminPlayer() : void {
        if (!$_SESSION('idAdminConnected') !== null) {
            $_SESSION['error'] = "Vous devez être connecté pour effectuer cette action.";
            header("Location:/admin/adminPlayer");
        }
        $players = $this->mdPlayer->getAllPlayers();
        if ($players != null) {
            echo $this->twig->render($this->vues["adminPlayer"], ['players' => $players]);
        } else {
            $_SESSION["error"] = "Aucun joueur trouvé.";
            echo $this->twig->render($this->vues["adminPlayer"]);
            unset($_SESSION["error"]);
        }
    }

    /**
     * Handles admin login.
     * Validates credentials and sets session variables.
     */
    public function loginAdmin() : void {
        try {
            $username = \usages\DataFilter::sanitizeString($_POST['username'] ?? '');
            $password = \usages\DataFilter::sanitizeString($_POST['password'] ?? '');

            // Validate fields
            if (empty($username) || empty($password)) {
                $_SESSION['error'] = "Tous les champs sont requis.";
                echo $this->twig->render($this->vues["login"], [
                    'error' => $_SESSION['error']
                ]);
                unset($_SESSION['error']);
                return;
            }
            $adminData = [
                'username' => $username,
                'password' => $password
            ];
            $adminId = $this->mdAdministrator->verifyAdministrator($adminData);
            if ($adminId == null) {
                $_SESSION['error'] = "Nom d'utilisateur ou mot de passe incorrect.";
                echo $this->twig->render($this->vues["login"], [
                    'error' => $_SESSION['error']
                ]);
                unset($_SESSION['error']);
            }
            $_SESSION['idAdminConnected'] = $adminId;
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "Connexion réussie. Bienvenue, " . $username . "!";
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
     * Displays the admin administrators management page.
     * Requires admin authentication.
     */
    public function adminAdministrators() : void {
//        if (!$_SESSION('idAdminConnected') !== null) {
//            $_SESSION['error'] = "Vous devez être connecté pour effectuer cette action.";
//            header("Location:/admin/adminPlayer");
//        }
        $admins = $this->mdAdministrator->getAllAdministrators();
        if ($admins != null) {
            echo $this->twig->render($this->vues["adminAdministrators"], ['admins' => $admins]);
        } else {
            $_SESSION["error"] = "Aucun admin trouvé.";
            echo $this->twig->render($this->vues["adminAdministrators"]);
            unset($_SESSION["error"]);
        }
    }

    /**
     * Displays the admin graph page.
     * Requires admin authentication.
     */
    public function adminGraph() : void {
        if (!$_SESSION('idAdminConnected') !== null) {
            $_SESSION['error'] = "Vous devez être connecté pour effectuer cette action.";
            header("Location:/admin/adminPlayer");
        }
        echo $this->twig->render($this->vues["adminGraph"]);
    }

    /**
     * Adds a new administrator.
     * Requires admin authentication.
     *
     * @param array $param Parameters for adding an administrator.
     */
    function addAdministrator(array $param): void
    {
        try {
            if (!$_SESSION('idAdminConnected') !== null) {
                $_SESSION['error'] = "Vous devez être connecté pour effectuer cette action.";
                header("Location:/admin/adminPlayer");
            }

            $username = \usages\DataFilter::sanitizeString($_POST['username']);
            $password = \usages\DataFilter::sanitizeString($_POST['password']);

            if (!isset($username) || !isset($password)) {
                $_SESSION["error"] = "Veuillez remplir tous les champs.";
                header("Location:/admin/adminAdministrators");
            } else {
                $Admin = [
                    'username' => $username,
                    'password' => $password,
                ];
                if ($this->mdAdministrator->verifyAdministrator($Admin) != null) {
                    $_SESSION["error"] = "Cet admin existe déjà.";
                    echo $this->twig->render($this->vues["adminAdministrators"],
                        [
                            "error" => $_SESSION["error"]
                        ]);
                } else {
                    $this->mdAdministrator->addAdministrator($Admin);
                    echo $this->twig->render($this->vues["adminAdministrators"],
                        [
                            "success" => "Admin ajouté avec succès."
                        ]);
                }
            }
        }
        catch (Exception $e) {
            $_SESSION["error"] = "Erreur lors de l'ajout de l'admin.";
            echo $this->twig->render($this->vues["adminAdministrators"],
                [
                    "error" => $_SESSION["error"]
                ]);
        }
    }

    /**
     * Adds a new player.
     * Requires admin authentication.
     */
    public function addPlayer(): void
    {
        try {

            if (!$_SESSION('idAdminConnected') !== null) {
                $_SESSION['error'] = "Vous devez être connecté pour effectuer cette action.";
                header("Location:/admin/adminPlayer");
            }
            
            // Retrieve form data
            $username = $_POST['username'] ?? null;
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;

            // Validate fields
            if (empty($username) || empty($email) || empty($password)) {
                $_SESSION['error'] = "Tous les champs sont requis.";
                header("Location:/admin/adminPlayer");
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Adresse email invalide.";
                header("Location:/admin/adminPlayer");
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
            $_SESSION['success'] = "Ajout d'un joueur réussie !";
            header("Location:/admin/adminPlayer");

        } catch (Exception $e) {
            $_SESSION['error'] = "Une erreur est survenue lors de l'ajout du joueur.";
            header("Location:/admin/adminPlayer");
        }
    }

    /**
     * Deletes a player.
     * Requires admin authentication.
     *
     * @param array $param Parameters for deleting a player.
     */
    public function deletePlayer(array $param): void {
        try {
            if (!$_SESSION('idAdminConnected') !== null) {
                $_SESSION['error'] = "Vous devez être connecté pour effectuer cette action.";
                header("Location:/admin/adminPlayer");
            }
            // Delete the player by ID
            $deleted = $this->mdPlayer->deletePlayerByID($param["id"]);
            if ($deleted) {
                $_SESSION['success'] = "Votre compte a été supprimé avec succès.";
                header("Location:/admin/adminPlayer");

            } else {
                $_SESSION['error'] = "Une erreur est survenue lors de la suppression de votre compte.";
                header("Location:/admin/adminPlayer");
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Une erreur inattendue est survenue : " . $e->getMessage();
            header("Location:/admin/adminPlayer");
        }
    }

}