<?php

namespace classes;

class Graph
{
    private int $id;
    private string $name;
    private int $vertexCount;
    private int $edgeCount;
    private string $status;

    public function __construct(int $id, string $name, int $vertexCount, int $edgeCount, string $status)
    {
        $this->id = $id;
        $this->name = $name;
        $this->vertexCount = $vertexCount;
        $this->edgeCount = $edgeCount;
        $this->status = $status;
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getVertexCount(): int
    {
        return $this->vertexCount;
    }

    public function getEdgeCount(): int
    {
        return $this->edgeCount;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    // Setters
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setVertexCount(int $vertexCount): void
    {
        $this->vertexCount = $vertexCount;
    }

    public function setEdgeCount(int $edgeCount): void
    {
        $this->edgeCount = $edgeCount;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
