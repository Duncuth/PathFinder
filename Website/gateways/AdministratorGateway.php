<?php

namespace gateways;

use usages\Connection;
use \PDO;

/**
 * Class AdministratorGateway
 *
 * This class provides methods to interact with the administrators in the database.
 */
class AdministratorGateway
{
    /**
     * @var Connection $con The database connection instance.
     */
    private $con;

    /**
     * AdministratorGateway constructor.
     * Initializes the database connection using global configuration variables.
     */
    public function __construct()
    {
        global $dsn, $user, $pass;
        if ($dsn == NULL || $user == NULL || $pass == NULL) {
            require_once(__DIR__ . '/../usages/Config_DB.php');
        }
        $this->con = new Connection($dsn, $user, $pass);
    }

    /**
     * Adds a new administrator to the database.
     *
     * @param array $admin An associative array containing administrator details.
     * @return void
     */
    public function addAdministrator($admin): void
    {
        $query = "INSERT INTO Admin (username, password) 
                  VALUES (:username, :password);";
        $this->con->executeQuery(
            $query,
            array(
                ':username' => array($admin['username'], PDO::PARAM_STR),
                ':password' => array(password_hash($admin['password'], PASSWORD_DEFAULT), PDO::PARAM_STR)
            )
        );
    }

    /**
     * Retrieves an administrator by ID.
     *
     * @param int $id The ID of the administrator.
     * @return array|null An associative array of administrator details or null if not found.
     */
    public function getAdministratorById(int $id): ?array
    {
        $query = "SELECT * FROM admin WHERE id = :id;";
        $this->con->executeQuery($query, array(':id' => array($id, PDO::PARAM_INT)));
        $results = $this->con->getResults();
        return $results ? $results[0] : null;
    }

    /**
     * Retrieves an administrator by username.
     *
     * @param string $username The username of the administrator.
     * @return array|null An associative array of administrator details or null if not found.
     */
    public function getAdministratorByUsername(string $username): ?array
    {
        $query = "SELECT * FROM admin WHERE username = :username;";
        $this->con->executeQuery($query, array(':username' => array($username, PDO::PARAM_STR)));
        $results = $this->con->getResults();
        return $results ? $results[0] : null;
    }

    /**
     * Updates an administrator in the database.
     *
     * @param int $id The ID of the administrator.
     * @param array $admin An associative array containing updated administrator details.
     * @return void
     */
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

    /**
     * Deletes an administrator by ID.
     *
     * @param int $id The ID of the administrator.
     * @return void
     */
    public function deleteAdministrator(int $id): void
    {
        $query = "DELETE FROM admin WHERE id = :id;";
        $this->con->executeQuery($query, array(':id' => array($id, PDO::PARAM_INT)));
    }

    /**
     * Verifies an administrator's credentials.
     *
     * @param array $admin An associative array containing administrator credentials.
     * @return int|null The ID of the administrator if credentials are valid, null otherwise.
     */
    public function verifyAdministrator($admin): ?int
    {
        $query = "SELECT Admin.id FROM Admin 
                  WHERE username = :username AND password = :password;";
        $this->con->executeQuery(
            $query,
            array(
                ':username' => array($admin['username'], PDO::PARAM_STR),
                ':password' => array(password_hash($admin['password'], PASSWORD_DEFAULT), PDO::PARAM_STR)
            )
        );
        $results = $this->con->getResults();
        return $results ? $results[0]['id'] : null;
    }

    /**
     * Retrieves all administrators from the database.
     *
     * @return array An array of associative arrays containing administrator details.
     */
    public function getAllAdministrators(): array
    {
        $query = "SELECT * FROM Admin;";
        $this->con->executeQuery($query);
        return $this->con->getResults();
    }
}