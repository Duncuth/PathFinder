<?php

namespace gateways;

use usages\Connection;
use \PDO;

class PlayerStatsGateway
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

    // Ajouter des statistiques pour un joueur
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

    // Récupérer les statistiques d'un joueur par son ID
    public function getPlayerStatsByPlayerId(int $playerId): ?array
    {
        $query = "SELECT * FROM playerstats WHERE player_id = :player_id;";
        $this->con->executeQuery($query, array(':player_id' => array($playerId, PDO::PARAM_INT)));
        $results = $this->con->getResults();
        return $results ? $results[0] : null;
    }

    // Récupérer toutes les statistiques
    public function getAllPlayerStats(): array
    {
        $query = "SELECT * FROM playerstats;";
        $this->con->executeQuery($query);
        return $this->con->getResults();
    }

    // Mettre à jour les statistiques d'un joueur
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

    // Supprimer les statistiques d'un joueur
    public function deletePlayerStatsByPlayerId(int $playerId): void
    {
        $query = "DELETE FROM playerstats WHERE player_id = :player_id;";
        $this->con->executeQuery($query, array(':player_id' => array($playerId, PDO::PARAM_INT)));
    }
}
