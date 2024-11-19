<?php

namespace classes;

/**
 * Class Graph
 *
 * Represents a graph with an ID, name, vertex count, edge count, and status.
 */
class Graph
{
    /**
     * @var int $id The unique identifier for the graph.
     */
    private int $id;

    /**
     * @var string $name The name of the graph.
     */
    private string $name;

    /**
     * @var int $vertexCount The number of vertices in the graph.
     */
    private int $vertexCount;

    /**
     * @var int $edgeCount The number of edges in the graph.
     */
    private int $edgeCount;

    /**
     * @var string $status The status of the graph.
     */
    private string $status;

    /**
     * Graph constructor.
     *
     * @param int $id The unique identifier for the graph.
     * @param string $name The name of the graph.
     * @param int $vertexCount The number of vertices in the graph.
     * @param int $edgeCount The number of edges in the graph.
     * @param string $status The status of the graph.
     */
    public function __construct(int $id, string $name, int $vertexCount, int $edgeCount, string $status)
    {
        $this->id = $id;
        $this->name = $name;
        $this->vertexCount = $vertexCount;
        $this->edgeCount = $edgeCount;
        $this->status = $status;
    }

    /**
     * Get the ID of the graph.
     *
     * @return int The unique identifier for the graph.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the name of the graph.
     *
     * @return string The name of the graph.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the number of vertices in the graph.
     *
     * @return int The number of vertices in the graph.
     */
    public function getVertexCount(): int
    {
        return $this->vertexCount;
    }

    /**
     * Get the number of edges in the graph.
     *
     * @return int The number of edges in the graph.
     */
    public function getEdgeCount(): int
    {
        return $this->edgeCount;
    }

    /**
     * Get the status of the graph.
     *
     * @return string The status of the graph.
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Set the name of the graph.
     *
     * @param string $name The new name of the graph.
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Set the number of vertices in the graph.
     *
     * @param int $vertexCount The new number of vertices in the graph.
     * @return void
     */
    public function setVertexCount(int $vertexCount): void
    {
        $this->vertexCount = $vertexCount;
    }

    /**
     * Set the number of edges in the graph.
     *
     * @param int $edgeCount The new number of edges in the graph.
     * @return void
     */
    public function setEdgeCount(int $edgeCount): void
    {
        $this->edgeCount = $edgeCount;
    }

    /**
     * Set the status of the graph.
     *
     * @param string $status The new status of the graph.
     * @return void
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}