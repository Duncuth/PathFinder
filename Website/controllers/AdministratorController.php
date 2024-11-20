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
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION["error"] = "Méthode non autorisée.";
            header("Location:/admin/administrators");
        } else {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            if (!isset($username) || !isset($email) || !isset($password) || empty($username) || empty($email) || empty($password)) {
                $_SESSION["error"] = "Veuillez remplir tous les champs.";
                header("Location:/admin/administrators");
            } else {
                $Admin = [
                    'username' => $username,
                    'email' => $email,
                    'password' => $password,
                ];
                if ($this->mdAdministrator->verifyAdministratorByName($Admin) != null) {
                    $_SESSION["error"] = "Cet admin existe déjà.";
                    header("Location:/admin/administrators");
                } else {
                    $this->mdAdministrator->addAdministrator($Admin);
                    header("Location:/admin/administrators");
                }
            }
        }
    }

    


}
