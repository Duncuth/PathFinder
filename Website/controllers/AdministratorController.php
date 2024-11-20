<?php

namespace controllers;

use \Exception;
use models\PlayerModel;
use \PDOException;
use models\AdministratorModel;

class AdministratorController
{
    private $mdAdministrator;
    private $mdPlayer;
    private $twig;
    private $vues;

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
        } catch (Exception $e2) {
            // Gérez d'autres erreurs ici
        }
    }

    public function adminPlayer() : void {
        $players = $this->mdPlayer->getAllPlayers();
        if ($players != null) {
            echo $this->twig->render($this->vues["adminPlayer"], ['players' => $players]);
        } else {
            $_SESSION["error"] = "Aucun joueur trouvé.";
            echo $this->twig->render($this->vues["adminPlayer"]);
            unset($_SESSION["error"]);
        }
    }

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

    public function adminAdministrators() : void {
        $admins = $this->mdAdministrator->getAllAdministrators();
        if ($admins != null) {
            echo $this->twig->render($this->vues["adminAdministrators"], ['admins' => $admins]);
        } else {
            $_SESSION["error"] = "Aucun admin trouvé.";
            echo $this->twig->render($this->vues["adminAdministrators"]);
            unset($_SESSION["error"]);
        }
    } 

    public function adminGraph() : void {
        echo $this->twig->render($this->vues["adminGraph"]);
    }   

    function addAdministrator($param)
    {
        try {
        $username = \usages\DataFilter::sanitizeString($_POST['username']);
        $password = \usages\DataFilter::sanitizeString($_POST['password']);

        if (!isset($username) || !isset($password) || empty($username) || empty($password)) {
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

    public function addPlayer(): void
    {
        try {
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
}
