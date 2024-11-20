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
        echo $this->twig->render($this->vues["adminAdministrators"]);
    } 

    public function adminGraph() : void {
        echo $this->twig->render($this->vues["adminGraph"]);
    }   

    function addAdministrator($param)
    {
        try {
        $username = \usages\DataFilter::sanitizeString($_POST['username']);
        $password = $_POST['password'];

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

            if (!isset($username) || !isset($password) || empty($username) || empty($password)) {
                $_SESSION["error"] = "Veuillez remplir tous les champs.";
                header("Location:/admin/adminAdministrators");
            } else {
                $Admin = [
                    'username' => $username,
                    'password' => $password,
                ];
                if ($this->mdAdministrator->verifyAdministratorByName($Admin) != null) {
                    $_SESSION["error"] = "Cet admin existe déjà.";
                    header("Location:/admin/administrators");
                } else {
                    $this->mdAdministrator->addAdministrator($Admin);
                    header("Location:/admin/adminAdministrators");
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

    


}
