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
    /**
     * @var Connection $con The database connection instance.
     */
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
     * @return void
     */
    public function addPlayer(array $player): void
    {
        $query = "INSERT INTO Player (username, email, password, avatar_url, is_moderator) 
                  VALUES (:username, :email, :password, :avatar_url, :is_moderator);";

        $this->con->executeQuery(
            $query,
            array(
                ':username' => array($player['username'], PDO::PARAM_STR),
                ':email' => array($player['email'], PDO::PARAM_STR),
                ':password' => array(password_hash($player['password'], PASSWORD_DEFAULT), PDO::PARAM_STR),
                ':avatar_url' => array($player['avatar_url'], PDO::PARAM_STR),
                ':is_moderator' => array((int)$player['is_moderator'], PDO::PARAM_INT)
            )
        );
    }

    /**
     * Retrieves a player by their username.
     *
     * @param string $username The username of the player.
     * @return array|false The player details or false if not found.
     */
    public function getPlayerByUsername(string $username): false|array
    {
        $query = "SELECT * FROM Player WHERE username = :username;";
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
    public function getPlayerByID(int $id): false|array
    {
        $query = "SELECT * FROM Player WHERE id = :id;";
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
    public function getPlayers(): array
    {
        $query = "SELECT * FROM Player;";
        $this->con->executeQuery($query);
        $results = $this->con->getResults();

        return $results;
    }

    /**
     * Updates a player's details in the database.
     *
     * @param int $id The ID of the player.
     * @param array $player Associative array containing updated player details.
     * @return bool True if the update was successful, false otherwise.
     */
    public function updatePlayer(int $id, array $player): bool
    {
        // Build the SQL query dynamically
        $fields = [];
        $params = [':id' => array($id, PDO::PARAM_INT)];

        if (!empty($player['username'])) {
            $fields[] = "username = :username";
            $params[':username'] = array($player['username'], PDO::PARAM_STR);
        }

        if (!empty($player['email'])) {
            $fields[] = "email = :email";
            $params[':email'] = array($player['email'], PDO::PARAM_STR);
        }

        if (!empty($player['password'])) {
            $fields[] = "password = :password";
            $params[':password'] = array(password_hash($player['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
        }

        if (!empty($player['avatar_url'])) {
            $fields[] = "avatar_url = :avatar_url";
            $params[':avatar_url'] = array($player['avatar_url'], PDO::PARAM_STR);
        }

        if (isset($player['is_moderator'])) {
            $fields[] = "is_moderator = :is_moderator";
            $params[':is_moderator'] = array($player['is_moderator'], PDO::PARAM_BOOL);
        }

        // If no fields to update, return false
        if (empty($fields)) {
            return false;
        }

        // Build the final SQL query
        $query = "UPDATE Player SET " . implode(", ", $fields) . " WHERE id = :id;";
        // Execute the query
        return $this->con->executeQuery($query, $params);
    }


    /**
     * Deletes a player from the database by their ID.
     *
     * @param int $id The ID of the player.
     * @return bool
     */
    public function deletePlayerByID(int $id): bool
    {
        $query = "DELETE FROM Player WHERE id = :id;";
        return $this->con->executeQuery(
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
    public function verifyPlayer(array $player): ?int
    {
        $query = "SELECT id, password FROM Player WHERE username = :username;";
        $this->con->executeQuery(
            $query,
            array(
                ':username' => array($player['username'], PDO::PARAM_STR)
            )
        );

        $results = $this->con->getResults();
        if ($results && password_verify($player['password'], $results[0]['password'])) {
            return $results[0]['id']; // Return the player ID if successful
        }

        return null;
    }

    /**
     * Check if a player is a moderator.
     *
     * This method queries the database to check if the player with the given ID has moderator status.
     *
     * @param int $playerId The ID of the player to check.
     * @return bool True if the player is a moderator, false otherwise.
     */
    public function checkModeratorStatus(int $playerId): bool
    {
        $query = "SELECT is_moderator FROM Player WHERE id = :id";
        $this->con->executeQuery($query, [':id' => [$playerId, PDO::PARAM_INT]]);
        $result = $this->con->getResults();


        return isset($result[0]['is_moderator']) && (bool)$result[0]['is_moderator'];
    }



}