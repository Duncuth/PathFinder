<?php

namespace gateways;

use usages\Connection;
use \PDO;

/**
 * Class PlayerGateway
 *
 * This class provides methods to interact with the players table in the database.
 */
class PlayerGateway
{
    private $con;

    /**
     * PlayerGateway constructor.
     * Initializes the database connection.
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
     * Adds a new player to the database.
     *
     * @param array $player Associative array containing player details.
     */
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

    /**
     * Retrieves a player by their username.
     *
     * @param string $username The username of the player.
     * @return array|false The player details or false if not found.
     */
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

    /**
     * Retrieves a player by their ID.
     *
     * @param int $id The ID of the player.
     * @return array|false The player details or false if not found.
     */
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

    /**
     * Retrieves all players from the database.
     *
     * @return array The list of all players.
     */
    public function getPlayers()
    {
        $query = "SELECT * FROM players;";
        $this->con->executeQuery($query);
        $results = $this->con->getResults();

        return $results;
    }

    /**
     * Updates a player's details in the database.
     *
     * @param int $id The ID of the player.
     * @param array $player Associative array containing updated player details.
     */
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

    /**
     * Updates a player's password in the database.
     *
     * @param int $id The ID of the player.
     * @param string $password The new password of the player.
     */
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

    /**
     * Deletes a player from the database by their ID.
     *
     * @param int $id The ID of the player.
     */
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

    /**
     * Verifies a player's credentials.
     *
     * @param array $player Associative array containing player credentials.
     * @return int|null The ID of the player if credentials are valid, null otherwise.
     */
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