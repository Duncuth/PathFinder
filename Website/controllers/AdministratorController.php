<?php

namespace controllers;

use \Exception;
use \PDOException;
use models\AdministratorModel;

class AdministratorController
{
    private $mdAdministrator;

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

            


        } catch (PDOException $e) {
            // Gérez les erreurs PDO ici
        } catch (Exception $e2) {
            // Gérez d'autres erreurs ici
        }
    }

    public function adminPlayer() : void {
        echo $this->twig->render($this->vues["adminPlayer"]);
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
                echo $this->twig->render($this->vues["adminPlayer"], [
                    'error' => $_SESSION['error']
                ]);
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Adresse email invalide.";
                echo $this->twig->render($this->vues["adminPlayer"], [
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
            $_SESSION['success'] = "Ajour d'un joueur réussie !";
            echo $this->twig->render($this->vues["adminAdministrators"], [
                'success' => $_SESSION['success']
            ]);

        } catch (Exception $e) {
            $_SESSION['error'] = "Une erreur est survenue lors de l'ajout du joueur.";
            echo $this->twig->render($this->vues["adminAdministrators"], [
                'error' => $_SESSION['error']
            ]);
        }

    }


}
