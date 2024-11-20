<?php

namespace classes;

/**
 * Class Vertex
 *
 * Represents a vertex with an ID, label, and the graph it belongs to.
 */
class Vertex
{
    /**
     * @var int $id The unique identifier for the vertex.
     */
    private int $id;

    /**
     * @var string $label The label of the vertex.
     */
    private string $label;

    /**
     * @var int $graphId The ID of the graph the vertex belongs to.
     */
    private int $graphId;

    /**
     * Vertex constructor.
     *
     * @param int $id The unique identifier for the vertex.
     * @param string $label The label of the vertex.
     * @param int $graphId The ID of the graph the vertex belongs to.
     */
    public function __construct(int $id, string $label, int $graphId)
    {
        $this->id = $id;
        $this->label = $label;
        $this->graphId = $graphId;
    }

    /**
     * Get the ID of the vertex.
     *
     * @return int The unique identifier for the vertex.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the label of the vertex.
     *
     * @return string The label of the vertex.
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Get the ID of the graph the vertex belongs to.
     *
     * @return int The ID of the graph the vertex belongs to.
     */
    public function getGraphId(): int
    {
        return $this->graphId;
    }

    /**
     * Set the label of the vertex.
     *
     * @param string $label The new label of the vertex.
     * @return void
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * Set the graph ID for the vertex.
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