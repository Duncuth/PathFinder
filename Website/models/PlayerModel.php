<?php

namespace models;

use gateways\PlayerGateway;
use gateways\PlayerStatsGateway;
use classes\Player;
use classes\PlayerStats;

/**
 * Class PlayerModel
 *
 * Provides methods to manage players and their statistics, including adding, verifying, retrieving, updating, and deleting players and their stats.
 */
class PlayerModel
{
    /**
     * @var PlayerGateway $gwPlayer The gateway for player data operations.
     */
    private $gwPlayer;

    /**
     * @var PlayerStatsGateway $gwPlayerStats The gateway for player statistics data operations.
     */
    private $gwPlayerStats;

    /**
     * PlayerModel constructor.
     *
     * Initializes the PlayerGateway and PlayerStatsGateway.
     */
    public function __construct()
    {
        $this->gwPlayer = new PlayerGateway();
        $this->gwPlayerStats = new PlayerStatsGateway();
    }

    /**
     * Add a new player.
     *
     * @param array $playerData The data of the player to add.
     * @return void
     */
    public function addPlayer($playerData)
    {
        $this->gwPlayer->addPlayer($playerData);
    }

    /**
     * Verify the credentials of a player.
     *
     * @param array $playerData The credentials of the player to verify.
     * @return int|null The ID of the player if verified, null otherwise.
     */
    public function verifyPlayer($playerData)
    {
        $playerId = $this->gwPlayer->verifyPlayer($playerData);
        return $playerId;
    }

    /**
     * Retrieve a player by ID.
     *
     * @param int $id The ID of the player to retrieve.
     * @return Player|null The player object if found, null otherwise.
     */
    public function getPlayerByID($id): ?Player
    {
        $playerData = $this->gwPlayer->getPlayerByID($id);
        if ($playerData) {
            return new Player(
                $playerData['id'],
                $playerData['username'],
                $playerData['email'],
                $playerData['password'],
                $playerData['avatar_url'],
                $playerData['is_moderator']
            );
        }
        return null;
    }

    /**
     * Update a player.
     *
     * @param int $id The ID of the player to update.
     * @param array $playerData The new data for the player.
     * @return bool
     */
    public function updatePlayer($id, $playerData)
    {
        return $this->gwPlayer->updatePlayer($id, $playerData);
    }


    /**
     * Delete a player by ID.
     *
     * @param int $id The ID of the player to delete.
     * @return bool
     */
    public function deletePlayerByID(int $id) : bool
    {
        return $this->gwPlayer->deletePlayerByID($id);
    }

    /**
     * Add statistics for a player.
     *
     * @param array $statsData The data of the statistics to add.
     * @return void
     */
    public function addPlayerStats($statsData)
    {
        $this->gwPlayerStats->addPlayerStats($statsData);
    }

    /**
     * Retrieve the statistics of a player by player ID.
     *
     * @param int $playerId The ID of the player whose statistics to retrieve.
     * @return PlayerStats|null The player statistics object if found, null otherwise.
     */
    public function getPlayerStatsByPlayerId($playerId): ?PlayerStats
    {
        $statsData = $this->gwPlayerStats->getPlayerStatsByPlayerId($playerId);
        if ($statsData) {
            return new PlayerStats(
                $statsData['id'],
                $statsData['player_id'],
                $statsData['games_played'],
                $statsData['games_won'],
                $statsData['total_score']
            );
        }
        return null;
    }

    /**
     * Retrieve all player statistics sorted by score.
     *
     * This method fetches all player statistics from the PlayerStatsGateway,
     * sorts them by score, and returns an array of PlayerStats objects.
     *
     * @return PlayerStats[]|null An array of PlayerStats objects if data is found, null otherwise.
     */
    public function getPlayerStatsSortedByScore()
    {
        $statsData = $this->gwPlayerStats->getAllPlayerStatsSortedByScore();
        if ($statsData) {
            $playerStats = [];
            foreach ($statsData as $stats) {
                $playerStats[] = new PlayerStats(
                    $stats['id'],
                    $stats['player_id'],
                    $stats['games_played'],
                    $stats['games_won'],
                    $stats['total_score']
                );
            }
            return $playerStats;
        }
        return null;
    }

    /**
     * Update the statistics of a player.
     *
     * @param int $playerId The ID of the player whose statistics to update.
     * @param array $statsData The new data for the statistics.
     * @return void
     */
    public function updatePlayerStats($playerId, $statsData)
    {
        $this->gwPlayerStats->updatePlayerStats($playerId, $statsData);
    }

    /**
     * Delete the statistics of a player by player ID.
     *
     * @param int $playerId The ID of the player whose statistics to delete.
     * @return void
     */
    public function deletePlayerStatsByPlayerId($playerId)
    {
        $this->gwPlayerStats->deletePlayerStatsByPlayerId($playerId);
    }


    /**
     * Check if a player is a moderator.
     *
     * This method calls the PlayerGateway to check if the player with the given ID has moderator status.
     * If an error occurs during the process, it logs the error and returns false.
     *
     * @param int $playerId The ID of the player to check.
     * @return bool True if the player is a moderator, false otherwise.
     */
    public function isModerator(int $playerId): bool
    {
        try {
            // Call the Gateway method to retrieve the status
            // Return the result
            return $this->gwPlayer->checkModeratorStatus($playerId);
        } catch (Exception $e) {
            return false;
        }

    }

    /**
     * Retrieve all players.
     *
     * Fetches all players from the database using the PlayerGateway and returns them as an array of Player objects.
     *
     * @return Player[]|null An array of Player objects if data is found, null otherwise.
     */
    public function getAllPlayers(): ?array
    {
        // Fetch raw data from the Gateway
        $playersData = $this->gwPlayer->getPlayers();
        // If no data is found, return null
        if (empty($playersData)) {
            return null;
        }
        // Transform each database record into a Player object
        $players = [];
        foreach ($playersData as $playerData) {
                $players[] = new Player(
                    $playerData['id'],
                    $playerData['username'],
                    $playerData['email'],
                    $playerData['password'],
                    $playerData['avatar_url'],
                    $playerData['is_moderator']
                );
        }
        return $players;
    }

}