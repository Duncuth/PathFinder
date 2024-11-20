<?php

namespace classes;

/**
 * Class Edge
 *
 * Represents an edge with an ID, its starting vertex, ending vertex, and the graph it belongs to.
 */
class Edge
{
    /**
     * @var int $id The unique identifier for the edge.
     */
    private int $id;

    /**
     * @var int $graphId The ID of the graph the edge belongs to.
     */
    private int $graphId;

    /**
     * @var int $startVertexId The ID of the starting vertex.
     */
    private int $startVertexId;

    /**
     * @var int $endVertexId The ID of the ending vertex.
     */
    private int $endVertexId;

    /**
     * Edge constructor.
     *
     * @param int $id The unique identifier for the edge.
     * @param int $graphId The ID of the graph the edge belongs to.
     * @param int $startVertexId The ID of the starting vertex.
     * @param int $endVertexId The ID of the ending vertex.
     */
    public function __construct(int $id, int $graphId, int $startVertexId, int $endVertexId)
    {
        $this->id = $id;
        $this->graphId = $graphId;
        $this->startVertexId = $startVertexId;
        $this->endVertexId = $endVertexId;
    }

    /**
     * Get the ID of the edge.
     *
     * @return int The unique identifier for the edge.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the ID of the graph the edge belongs to.
     *
     * @return int The ID of the graph the edge belongs to.
     */
    public function getGraphId(): int
    {
        return $this->graphId;
    }

    /**
     * Get the ID of the starting vertex.
     *
     * @return int The ID of the starting vertex.
     */
    public function getStartVertexId(): int
    {
        return $this->startVertexId;
    }

    /**
     * Get the ID of the ending vertex.
     *
     * @return int The ID of the ending vertex.
     */
    public function getEndVertexId(): int
    {
        return $this->endVertexId;
    }

    /**
     * Set the starting vertex ID for the edge.
     *
     * @param int $startVertexId The new starting vertex ID.
     * @return void
     */
    public function setStartVertexId(int $startVertexId): void
    {
        $this->startVertexId = $startVertexId;
    }

    /**
     * Set the ending vertex ID for the edge.
     *
     * @param int $endVertexId The new ending vertex ID.
     * @return void
     */
    public function setEndVertexId(int $endVertexId): void
    {
        $this->endVertexId = $endVertexId;
    }

    /**
     * Set the graph ID for the edge.
     *
     * @param int $graphId The new graph ID.
     * @return void
     */
    public function setGraphId(int $graphId): void
    {
        $this->graphId = $graphId;
    }
}

?>