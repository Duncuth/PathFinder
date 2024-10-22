<?php

namespace classes;

class Player
{
    private int $id;
    private string $nickname;
    private string $pass;
    private int $score;

    private function __construct(int $id, string $nickname, string $pass)
    {
        $this->id = $id;
        $this->nickname = $nickname;
        $this->pass = $pass;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }


    public function getPass(): string
    {
        return $this->pass;
    }

    public function setPass(string $pass): void
    {
        $this->pass = $pass;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): void
    {
        $this->score = $score;
    }


}