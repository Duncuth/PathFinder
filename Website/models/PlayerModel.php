<?php

namespace models;

use gateways\GatewayPlayer;
use gateways\PlayerStatsGateway;
use classes\Player;
use classes\PlayerStats;

class PlayerModel
{
    private $gwPlayer;
    private $gwPlayerStats;

    public function __construct()
    {
        $this->gwPlayer = new GatewayPlayer();
        $this->gwPlayerStats = new PlayerStatsGateway();
    }

    // Ajouter un joueur
    public function addPlayer($playerData)
    {
        $this->gwPlayer->addPlayer($playerData);
    }

    // Vérifier les identifiants d'un joueur
    public function verifyPlayer($playerData)
    {
        $playerId = $this->gwPlayer->verifyPlayer($playerData);
        return $playerId;
    }

    // Récupérer un joueur par ID
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

    // Mettre à jour un joueur
    public function updatePlayer($id, $playerData)
    {
        $this->gwPlayer->updatePlayer($id, $playerData);
    }

    // Mettre à jour le mot de passe d'un joueur
    public function updatePlayerPassword($id, $password)
    {
        $this->gwPlayer->updatePlayerPassword($id, $password);
    }

    // Supprimer un joueur par ID
    public function deletePlayerByID($id)
    {
        $this->gwPlayer->deletePlayerByID($id);
    }

    // Ajouter des statistiques pour un joueur
    public function addPlayerStats($statsData)
    {
        $this->gwPlayerStats->addPlayerStats($statsData);
    }

    // Récupérer les statistiques d'un joueur par ID
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

    // Mettre à jour les statistiques d'un joueur
    public function updatePlayerStats($playerId, $statsData)
    {
        $this->gwPlayerStats->updatePlayerStats($playerId, $statsData);
    }

    // Supprimer les statistiques d'un joueur par ID
    public function deletePlayerStatsByPlayerId($playerId)
    {
        $this->gwPlayerStats->deletePlayerStatsByPlayerId($playerId);
    }
}
