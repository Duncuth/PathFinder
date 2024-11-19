<?php

namespace gateways;

use usages\Connection;
use \PDO;

class GraphGateway
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

    // Ajouter un graphe
    public function addGraph($graph): void
    {
        $query = "INSERT INTO graph (name, vertex_count, edge_count, status) 
                  VALUES (:name, :vertex_count, :edge_count, :status);";
        $this->con->executeQuery(
            $query,
            array(
                ':name' => array($graph['name'], PDO::PARAM_STR),
                ':vertex_count' => array($graph['vertex_count'], PDO::PARAM_INT),
                ':edge_count' => array($graph['edge_count'], PDO::PARAM_INT),
                ':status' => array($graph['status'], PDO::PARAM_STR)
            )
        );
    }

    // Récupérer un graphe par ID
    public function getGraphById(int $id): ?array
    {
        $query = "SELECT * FROM graph WHERE id = :id;";
        $this->con->executeQuery($query, array(':id' => array($id, PDO::PARAM_INT)));
        $results = $this->con->getResults();
        return $results ? $results[0] : null;
    }

    // Récupérer tous les graphes
    public function getAllGraphs(): array
    {
        $query = "SELECT * FROM graph;";
        $this->con->executeQuery($query);
        return $this->con->getResults();
    }

    // Mettre à jour un graphe
    public function updateGraph($id, $graph): void
    {
        $query = "UPDATE graph 
                  SET name = :name, vertex_count = :vertex_count, edge_count = :edge_count, status = :status 
                  WHERE id = :id;";
        $this->con->executeQuery(
            $query,
            array(
                ':id' => array($id, PDO::PARAM_INT),
                ':name' => array($graph['name'], PDO::PARAM_STR),
                ':vertex_count' => array($graph['vertex_count'], PDO::PARAM_INT),
                ':edge_count' => array($graph['edge_count'], PDO::PARAM_INT),
                ':status' => array($graph['status'], PDO::PARAM_STR)
            )
        );
    }

    // Supprimer un graphe par ID
    public function deleteGraph(int $id): void
    {
        $query = "DELETE FROM graph WHERE id = :id;";
        $this->con->executeQuery($query, array(':id' => array($id, PDO::PARAM_INT)));
    }
}
