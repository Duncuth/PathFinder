<?php

namespace models;

use gateways\GraphGateway;
use classes\Graph;

/**
 * Class GraphModel
 *
 * Provides methods to manage graphs, including adding, retrieving, updating, and deleting graphs.
 */
class GraphModel
{
    /**
     * @var GraphGateway $gwGraph The gateway for graph data operations.
     */
    private $gwGraph;

    /**
     * GraphModel constructor.
     *
     * Initializes the GraphGateway.
     */
    public function __construct()
    {
        $this->gwGraph = new GraphGateway();
    }

    /**
     * Add a new graph.
     *
     * @param array $graphData The data of the graph to add.
     * @return void
     */
    public function addGraph($graphData)
    {
        $this->gwGraph->addGraph($graphData);
    }

    /**
     * Retrieve a graph by ID.
     *
     * @param int $id The ID of the graph to retrieve.
     * @return Graph|null The graph object if found, null otherwise.
     */
    public function getGraphById($id): ?Graph
    {
        $graphData = $this->gwGraph->getGraphById($id);
        if ($graphData) {
            return new Graph(
                $graphData['id'],
                $graphData['name'],
                $graphData['vertex_count'],
                $graphData['edge_count'],
                $graphData['status']
            );
        }
        return null;
    }

    /**
     * Retrieve all graphs.
     *
     * @return array An array of graph objects.
     */
    public function getAllGraphs(): array
    {
        $graphsData = $this->gwGraph->getAllGraphs();
        $graphs = [];
        foreach ($graphsData as $graphData) {
            $graphs[] = new Graph(
                $graphData['id'],
                $graphData['name'],
                $graphData['vertex_count'],
                $graphData['edge_count'],
                $graphData['status']
            );
        }
        return $graphs;
    }

    /**
     * Update a graph.
     *
     * @param int $id The ID of the graph to update.
     * @param array $graphData The new data for the graph.
     * @return void
     */
    public function updateGraph($id, $graphData)
    {
        $this->gwGraph->updateGraph($id, $graphData);
    }

    /**
     * Delete a graph by ID.
     *
     * @param int $id The ID of the graph to delete.
     * @return void
     */
    public function deleteGraph($id)
    {
        $this->gwGraph->deleteGraph($id);
    }
}