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

            if ($_SESSION["idAdminConnected"] != null) {
                $this->twig = $twig;
                $this->vues = $vues;

                $this->mdAdministrator = new AdministratorModel();

                $administrators = $this->mdAdministrator->getAdministrators();

                echo $twig->render($vues["adminAdministrators"], [
                    'administrators' => $administrators,
                    'error' => $_SESSION["error"],
                ]);
                $_SESSION["error"] = null;
            } else {
                header("Location:/loginAdmin");
            }
        } catch (PDOException $e) {
            // Gérez les erreurs PDO ici
        } catch (Exception $e2) {
            // Gérez d'autres erreurs ici
        }
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
