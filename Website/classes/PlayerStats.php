<?php

namespace classes;

class PlayerStats
{
    private int $id;
    private int $playerId;
    private int $gamesPlayed;
    private int $gamesWon;
    private int $totalScore;

    public function __construct(int $id, int $playerId, int $gamesPlayed, int $gamesWon, int $totalScore)
    {
        $this->id = $id;
        $this->playerId = $playerId;
        $this->gamesPlayed = $gamesPlayed;
        $this->gamesWon = $gamesWon;
        $this->totalScore = $totalScore;
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getPlayerId(): int
    {
        return $this->playerId;
    }

    public function getGamesPlayed(): int
    {
        return $this->gamesPlayed;
    }

    public function getGamesWon(): int
    {
        return $this->gamesWon;
    }

    public function getTotalScore(): int
    {
        return $this->totalScore;
    }

    // Setters
    public function setGamesPlayed(int $gamesPlayed): void
    {
        $this->gamesPlayed = $gamesPlayed;
    }

    public function setGamesWon(int $gamesWon): void
    {
        $this->gamesWon = $gamesWon;
    }

    public function setTotalScore(int $totalScore): void
    {
        $this->totalScore = $totalScore;
    }
}
