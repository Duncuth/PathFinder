<?php

namespace gateways;

use classes\Player;
use usages\Connection;

class PlayerGateway
{
    private Connection $connection;

    public function __construct()
    {
        global $dsn, $user, $pass;
        if($dsn == NULL || $user == NULL || $pass == NULL){
            require_once(__DIR__ . '/../usages/Config_DB.php');
        }
        $this->connection = new Connection($dsn, $user, $pass);
    }

    public function createPlayer(string $nickname, string $pass): bool
    {
        $query = "INSERT INTO players (nickname, pass) VALUES (:nickname, :pass)";
        $parameters = [
            ':nickname' => [$nickname, \PDO::PARAM_STR],
            ':pass' => [$pass, \PDO::PARAM_STR]
        ];
        return $this->connection->executeQuery($query, $parameters);
    }

//    public function getPlayer(int $id): ?Player
//    {
//        $query = "SELECT * FROM players WHERE id = :id";
//        $parameters = [':id' => [$id, \PDO::PARAM_INT]];
//        $this->connection->executeQuery($query, $parameters);
//        $result = $this->connection->getResults();
//
//        if (count($result) === 0) {
//            return null;
//        }
//
//        $row = $result[0];
//        return new Player($row['id'], $row['nickname'], $row['pass']);
//    }

    public function updatePlayer(Player $player): bool
    {
        $query = "UPDATE players SET nickname = :nickname, pass = :pass, score = :score WHERE id = :id";
        $parameters = [
            ':nickname' => [$player->getNickname(), \PDO::PARAM_STR],
            ':pass' => [$player->getPass(), \PDO::PARAM_STR],
            ':score' => [$player->getScore(), \PDO::PARAM_INT],
            ':id' => [$player->getId(), \PDO::PARAM_INT]
        ];
        return $this->connection->executeQuery($query, $parameters);
    }

    public function deletePlayer(int $id): bool
    {
        $query = "DELETE FROM players WHERE id = :id";
        $parameters = [':id' => [$id, \PDO::PARAM_INT]];
        return $this->connection->executeQuery($query, $parameters);
    }

}
