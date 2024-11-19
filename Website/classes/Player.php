<?php

namespace classes;

class Player
{
    private int $id;
    private string $username;
    private string $email;
    private string $password;
    private ?string $avatarUrl;
    private bool $isModerator;

    public function __construct(
        int $id,
        string $username,
        string $email,
        string $password,
        ?string $avatarUrl,
        bool $isModerator
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->avatarUrl = $avatarUrl;
        $this->isModerator = $isModerator;
    }

    // Getters

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    public function isModerator(): bool
    {
        return $this->isModerator;
    }

    // Setters

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setAvatarUrl(?string $avatarUrl): void
    {
        $this->avatarUrl = $avatarUrl;
    }

    public function setModerator(bool $isModerator): void
    {
        $this->isModerator = $isModerator;
    }
}
