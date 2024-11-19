<?php

namespace models;

use gateways\GraphGateway;
use classes\Graph;

class GraphModel
{
    private $gwGraph;

    public function __construct()
    {
        $this->gwGraph = new GraphGateway();
    }

    // Ajouter un graphe
    public function addGraph($graphData)
    {
        $this->gwGraph->addGraph($graphData);
    }

    // Récupérer un graphe par ID
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

    // Récupérer tous les graphes
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

    // Mettre à jour un graphe
    public function updateGraph($id, $graphData)
    {
        $this->gwGraph->updateGraph($id, $graphData);
    }

    // Supprimer un graphe par ID
    public function deleteGraph($id)
    {
        $this->gwGraph->deleteGraph($id);
    }
}
