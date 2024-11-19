<?php

namespace gateways;

use usages\Connection;
use \PDO;

class GatewayPlayer
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

    public function addPlayer($player)
    {
        $query = "INSERT INTO players (username, email, password, avatar_url, is_moderator) 
                  VALUES (:username, :email, :password, :avatar_url, :is_moderator);";
        $this->con->executeQuery(
            $query,
            array(
                ':username' => array($player['username'], PDO::PARAM_STR),
                ':email' => array($player['email'], PDO::PARAM_STR),
                ':password' => array(md5($player['password']), PDO::PARAM_STR), // À améliorer avec password_hash
                ':avatar_url' => array($player['avatar_url'], PDO::PARAM_STR),
                ':is_moderator' => array($player['is_moderator'], PDO::PARAM_BOOL)
            )
        );
    }

    public function getPlayerByUsername(string $username)
    {
        $query = "SELECT * FROM players WHERE username = :username;";
        $this->con->executeQuery($query, array(':username' => array($username, PDO::PARAM_STR)));
        $results = $this->con->getResults();
        if ($results == NULL) {
            return false;
        }
        return $results[0];
    }

    public function getPlayerByID(int $id)
    {
        $query = "SELECT * FROM players WHERE id = :id;";
        $this->con->executeQuery($query, array(':id' => array($id, PDO::PARAM_INT)));
        $results = $this->con->getResults();
        if ($results == NULL) {
            return false;
        }
        return $results[0];
    }

    public function getPlayers()
    {
        $query = "SELECT * FROM players;";
        $this->con->executeQuery($query);
        $results = $this->con->getResults();

        return $results;
    }

    public function updatePlayer($id, $player)
    {
        $query = "UPDATE players 
                  SET username = :username, email = :email, password = :password, avatar_url = :avatar_url, is_moderator = :is_moderator 
                  WHERE id = :id;";
        $this->con->executeQuery(
            $query,
            array(
                ':id' => array($id, PDO::PARAM_INT),
                ':username' => array($player['username'], PDO::PARAM_STR),
                ':email' => array($player['email'], PDO::PARAM_STR),
                ':password' => array(md5($player['password']), PDO::PARAM_STR), // À améliorer avec password_hash
                ':avatar_url' => array($player['avatar_url'], PDO::PARAM_STR),
                ':is_moderator' => array($player['is_moderator'], PDO::PARAM_BOOL)
            )
        );
    }

    public function updatePlayerPassword($id, $password)
    {
        $query = "UPDATE players SET password = :password WHERE id = :id;";
        $this->con->executeQuery(
            $query,
            array(
                ':id' => array($id, PDO::PARAM_INT),
                ':password' => array(md5($password), PDO::PARAM_STR) // À améliorer avec password_hash
            )
        );
    }

    public function deletePlayerByID($id)
    {
        $query = "DELETE FROM players WHERE id = :id;";
        $this->con->executeQuery(
            $query,
            array(
                ':id' => array($id, PDO::PARAM_INT)
            )
        );
    }

    public function verifyPlayer($player)
    {
        $query = "SELECT players.id FROM players 
                  WHERE username = :username AND password = :password;";
        $this->con->executeQuery(
            $query,
            array(
                ':username' => array($player['username'], PDO::PARAM_STR),
                ':password' => array(md5($player['password']), PDO::PARAM_STR) // À améliorer avec password_verify
            )
        );
        $results = $this->con->getResults();
        return $results ? $results[0]['id'] : null;
    }
}
