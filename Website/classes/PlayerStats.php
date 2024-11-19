<?php

namespace classes;

/**
 * Class PlayerStats
 *
 * This class represents the player statistics.
 */
class PlayerStats
{
    /**
     * @var int $id The unique identifier for the player stats.
     */
    private int $id;

    /**
     * @var int $playerId The unique identifier for the player.
     */
    private int $playerId;

    /**
     * @var int $gamesPlayed The number of games played by the player.
     */
    private int $gamesPlayed;

    /**
     * @var int $gamesWon The number of games won by the player.
     */
    private int $gamesWon;

    /**
     * @var int $totalScore The total score of the player.
     */
    private int $totalScore;

    /**
     * PlayerStats constructor.
     *
     * @param int $id The unique identifier for the player stats.
     * @param int $playerId The unique identifier for the player.
     * @param int $gamesPlayed The number of games played by the player.
     * @param int $gamesWon The number of games won by the player.
     * @param int $totalScore The total score of the player.
     */
    public function __construct(int $id, int $playerId, int $gamesPlayed, int $gamesWon, int $totalScore)
    {
        $this->id = $id;
        $this->playerId = $playerId;
        $this->gamesPlayed = $gamesPlayed;
        $this->gamesWon = $gamesWon;
        $this->totalScore = $totalScore;
    }

    /**
     * Gets the unique identifier for the player stats.
     *
     * @return int The unique identifier for the player stats.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Gets the unique identifier for the player.
     *
     * @return int The unique identifier for the player.
     */
    public function getPlayerId(): int
    {
        return $this->playerId;
    }

    /**
     * Gets the number of games played by the player.
     *
     * @return int The number of games played by the player.
     */
    public function getGamesPlayed(): int
    {
        return $this->gamesPlayed;
    }

    /**
     * Gets the number of games won by the player.
     *
     * @return int The number of games won by the player.
     */
    public function getGamesWon(): int
    {
        return $this->gamesWon;
    }

    /**
     * Gets the total score of the player.
     *
     * @return int The total score of the player.
     */
    public function getTotalScore(): int
    {
        return $this->totalScore;
    }

    /**
     * Sets the number of games played by the player.
     *
     * @param int $gamesPlayed The number of games played by the player.
     * @return void
     */
    public function setGamesPlayed(int $gamesPlayed): void
    {
        $this->gamesPlayed = $gamesPlayed;
    }

    /**
     * Sets the number of games won by the player.
     *
     * @param int $gamesWon The number of games won by the player.
     * @return void
     */
    public function setGamesWon(int $gamesWon): void
    {
        $this->gamesWon = $gamesWon;
    }

    /**
     * Sets the total score of the player.
     *
     * @param int $totalScore The total score of the player.
     * @return void
     */
    public function setTotalScore(int $totalScore): void
    {
        $this->totalScore = $totalScore;
    }
}