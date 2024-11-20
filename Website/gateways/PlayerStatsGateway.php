<?php

namespace gateways;

use usages\Connection;
use \PDO;

/**
 * Class PlayerStatsGateway
 *
 * This class provides methods to interact with the player statistics in the database.
 */
class PlayerStatsGateway
{
    /**
     * @var Connection $con The database connection instance.
     */
    private $con;

    /**
     * PlayerStatsGateway constructor.
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
     * Adds player statistics to the database.
     *
     * @param array $stats An associative array containing player statistics.
     * @return void
     */
    public function addPlayerStats($stats): void
    {
        $query = "INSERT INTO playerstats (player_id, games_played, games_won, total_score) 
                  VALUES (:player_id, :games_played, :games_won, :total_score);";
        $this->con->executeQuery(
            $query,
            array(
                ':player_id' => array($stats['player_id'], PDO::PARAM_INT),
                ':games_played' => array($stats['games_played'], PDO::PARAM_INT),
                ':games_won' => array($stats['games_won'], PDO::PARAM_INT),
                ':total_score' => array($stats['total_score'], PDO::PARAM_INT)
            )
        );
    }

    /**
     * Retrieves player statistics by player ID.
     *
     * @param int $playerId The ID of the player.
     * @return array|null An associative array of player statistics or null if not found.
     */
    public function getPlayerStatsByPlayerId(int $playerId): ?array
    {
        $query = "SELECT * FROM playerstats WHERE player_id = :player_id;";
        $this->con->executeQuery($query, array(':player_id' => array($playerId, PDO::PARAM_INT)));
        $results = $this->con->getResults();
        return $results ? $results[0] : null;
    }

    /**
     * Retrieves all player statistics.
     *
     * @return array An array of associative arrays containing player statistics.
     */
    public function getAllPlayerStats(): array
    {
        $query = "SELECT * FROM playerstats;";
        $this->con->executeQuery($query);
        return $this->con->getResults();
    }

    /**
     * Retrieves all player statistics sorted by total score in descending order.
     *
     * This method executes a SQL query to fetch all player statistics from the database,
     * sorts them by the total score in descending order, and returns the results.
     *
     * @return array An array of associative arrays containing player statistics.
     */
    public function getAllPlayerStatsSortedByScore(): array
    {
        $query = "SELECT * FROM playerstats ORDER BY total_score DESC;";
        $this->con->executeQuery($query);
        $result = $this->con->getResults();
        return $result[0];
    }

    /**
     * Updates player statistics in the database.
     *
     * @param int $playerId The ID of the player.
     * @param array $stats An associative array containing updated player statistics.
     * @return void
     */
    public function updatePlayerStats($playerId, $stats): void
    {
        $query = "UPDATE playerstats 
                  SET games_played = :games_played, games_won = :games_won, total_score = :total_score 
                  WHERE player_id = :player_id;";
        $this->con->executeQuery(
            $query,
            array(
                ':player_id' => array($playerId, PDO::PARAM_INT),
                ':games_played' => array($stats['games_played'], PDO::PARAM_INT),
                ':games_won' => array($stats['games_won'], PDO::PARAM_INT),
                ':total_score' => array($stats['total_score'], PDO::PARAM_INT)
            )
        );
    }

    /**
     * Deletes player statistics by player ID.
     *
     * @param int $playerId The ID of the player.
     * @return void
     */
    public function deletePlayerStatsByPlayerId(int $playerId): void
    {
        $query = "DELETE FROM playerstats WHERE player_id = :player_id;";
        $this->con->executeQuery($query, array(':player_id' => array($playerId, PDO::PARAM_INT)));
    }
}