<?php

namespace gateways;

use usages\Connection;
use \PDO;

/**
 * Class GraphGateway
 *
 * This class provides methods to interact with the graphs in the database.
 */
class GraphGateway
{
    /**
     * @var Connection $con The database connection instance.
     */
    private $con;

    /**
     * GraphGateway constructor.
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
     * Adds a new graph to the database.
     *
     * @param array $graph An associative array containing graph details.
     * @return void
     */
    public function addGraph($graph): void
    {
        $query = "INSERT INTO Graph (name, vertex_count, edge_count, difficulty) 
                  VALUES (:name, :vertex_count, :edge_count, :difficulty);";
        $this->con->executeQuery(
            $query,
            array(
                ':name' => array($graph['name'], PDO::PARAM_STR),
                ':vertex_count' => array($graph['vertex_count'], PDO::PARAM_INT),
                ':edge_count' => array($graph['edge_count'], PDO::PARAM_INT),
                ':difficulty' => array($graph['difficulty'], PDO::PARAM_STR)
            )
        );
    }

    /**
     * Retrieves a graph by ID.
     *
     * @param int $id The ID of the graph.
     * @return array|null An associative array of graph details or null if not found.
     */
    public function getGraphById(int $id): ?array
    {
        $query = "SELECT * FROM Graph WHERE id = :id;";
        $this->con->executeQuery($query, array(':id' => array($id, PDO::PARAM_INT)));
        $results = $this->con->getResults();
        return $results ? $results[0] : null;
    }

    public function getVerticesByGraphId(int $graphId): array
    {
        $query = "SELECT * FROM Vertex WHERE graph_id = :graph_id";
        $this->con->executeQuery($query, [':graph_id' => [$graphId, PDO::PARAM_INT]]);
        return $this->con->getResults();
    }

    public function getEdgesByGraphId(int $graphId): array
    {
        $query = "SELECT * FROM Edge WHERE graph_id = :graph_id";
        $this->con->executeQuery($query, [':graph_id' => [$graphId, PDO::PARAM_INT]]);
        return $this->con->getResults();
    }

    /**
     * Retrieves all graphs.
     *
     * @return array An array of associative arrays containing graph details.
     */
    public function getAllGraphs(): array
    {
        $query = "SELECT * FROM Graph;";
        $this->con->executeQuery($query);
        return $this->con->getResults();
    }

    /**
     * Updates a graph in the database.
     *
     * @param int $id The ID of the graph.
     * @param array $graph An associative array containing updated graph details.
     * @return void
     */
    public function updateGraph($id, $graph): void
    {
        $query = "UPDATE Graph 
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

    /**
     * Deletes a graph by ID.
     *
     * @param int $id The ID of the graph.
     * @return void
     */
    public function deleteGraph(int $id): void
    {
        $query = "DELETE FROM Graph WHERE id = :id;";
        $this->con->executeQuery($query, array(':id' => array($id, PDO::PARAM_INT)));
    }

}