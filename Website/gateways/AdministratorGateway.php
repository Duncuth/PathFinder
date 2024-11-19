<?php

namespace gateways;

use usages\Connection;
use \PDO;

class AdministratorGateway
{
    private $con;

    public function __construct()
    {
        global $dsn, $user, $pass;
        if ($dsn == NULL || $user == NULL || $pass == NULL) {
            require_once(__DIR__ . '/../usages/Config_DB.php');
        }
        $this->con = new Connection($dsn, $user, $pass);
    }

    // Ajouter un administrateur
    public function addAdministrator($admin): void
    {
        $query = "INSERT INTO admin (username, password) 
                  VALUES (:username, :password);";
        $this->con->executeQuery(
            $query,
            array(
                ':username' => array($admin['username'], PDO::PARAM_STR),
                ':password' => array(md5($admin['password']), PDO::PARAM_STR) // À améliorer avec password_hash
            )
        );
    }

    // Récupérer un administrateur par ID
    public function getAdministratorById(int $id): ?array
    {
        $query = "SELECT * FROM admin WHERE id = :id;";
        $this->con->executeQuery($query, array(':id' => array($id, PDO::PARAM_INT)));
        $results = $this->con->getResults();
        return $results ? $results[0] : null;
    }

    // Récupérer un administrateur par username
    public function getAdministratorByUsername(string $username): ?array
    {
        $query = "SELECT * FROM admin WHERE username = :username;";
        $this->con->executeQuery($query, array(':username' => array($username, PDO::PARAM_STR)));
        $results = $this->con->getResults();
        return $results ? $results[0] : null;
    }

    // Mettre à jour un administrateur
    public function updateAdministrator($id, $admin): void
    {
        $query = "UPDATE admin 
                  SET username = :username, password = :password 
                  WHERE id = :id;";
        $this->con->executeQuery(
            $query,
            array(
                ':id' => array($id, PDO::PARAM_INT),
                ':username' => array($admin['username'], PDO::PARAM_STR),
                ':password' => array(md5($admin['password']), PDO::PARAM_STR) // À améliorer avec password_hash
            )
        );
    }

    // Supprimer un administrateur par ID
    public function deleteAdministrator(int $id): void
    {
        $query = "DELETE FROM admin WHERE id = :id;";
        $this->con->executeQuery($query, array(':id' => array($id, PDO::PARAM_INT)));
    }

    // Vérifier un administrateur (connexion)
    public function verifyAdministrator($admin): ?int
    {
        $query = "SELECT admin.id FROM admin 
                  WHERE username = :username AND password = :password;";
        $this->con->executeQuery(
            $query,
            array(
                ':username' => array($admin['username'], PDO::PARAM_STR),
                ':password' => array(md5($admin['password']), PDO::PARAM_STR) // À améliorer avec password_verify
            )
        );
        $results = $this->con->getResults();
        return $results ? $results[0]['id'] : null;
    }
}
