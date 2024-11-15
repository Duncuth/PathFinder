<?php

namespace gateways;

use classes\Player;
use usages\Connection;

class PlayerGateway
{
    private Connection $connection;

    public function __construct()
    {
        global $dsn, $user, $pass;
        if($dsn == NULL || $user == NULL || $pass == NULL){
            require_once(__DIR__ . '/../usages/Config_DB.php');
        }
        $this->connection = new Connection($dsn, $user, $pass);
    }

    public function createPlayer($player)
    {
        $query = "INSERT INTO Player (username, password, email) VALUES (:username, :password, :email)";
        $this->connection->executeQuery($query, array(
                ':username' => array($player['username'], PDO::PARAM_STR),
                ':password' => array(md5($player['password']), PDO::PARAM_STR),
                ':email' => array($player['email'], PDO::PARAM_STR)
                ));
    }

    public function getPlayerByUsername(string $username)
    {
        $query = "SELECT * FROM Player WHERE username = :username;";
        $this->con->executeQuery($query, array(':username' => array($username, PDO::PARAM_STR)));
        $results = $this->con->getResults();
        if ($results == NULL) {
            return false;
        }
        return $results[0];

    }

    public function getPlayerByID(int $id)
    {
        $query = "SELECT * FROM Player WHERE id = :id;";
        $this->con->executeQuery($query, array(':id' => array($id, PDO::PARAM_INT)));
        $results = $this->con->getResults();
        if ($results == NULL) {
            return false;
        }
        return $results[0];
    }

    public function deletePlayerByID(int $id)
    {
        $query = "DELETE FROM Player WHERE id = :id;";
        $this->con->executeQuery(
            $query,
            array(
                ':id' => array($id, PDO::PARAM_INT)
            )
        );
    }


}
