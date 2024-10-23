<?php

namespace models;

use gateways\PlayerGateway;
use classes\Player;

class PlayerModel
{
    private $gateway;

    public function __construct()
    {
        $this->gateway = new PlayerGateway();
    }

    public function createPlayer(string $nickname, string $pass): bool
    {
        return $this->gateway->createPlayer($nickname, $pass);
    }

    public function getPlayer(int $id): ?Player
    {
        return $this->gateway->getPlayer($id);
    }

    public function updatePlayer(Player $player): bool
    {
        return $this->gateway->updatePlayer($player);
    }

    public function deletePlayer(int $id): bool
    {
        return $this->gateway->deletePlayer($id);
    }
}