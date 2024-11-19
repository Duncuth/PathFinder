<?php

namespace classes;

/**
 * Class Player
 *
 * This class represents a player with various attributes and methods to get and set these attributes.
 */
class Player
{
    /**
     * @var int $id The unique identifier for the player.
     */
    private int $id;

    /**
     * @var string $username The username of the player.
     */
    private string $username;

    /**
     * @var string $email The email address of the player.
     */
    private string $email;

    /**
     * @var string $password The password of the player.
     */
    private string $password;

    /**
     * @var string|null $avatarUrl The URL of the player's avatar.
     */
    private ?string $avatarUrl;

    /**
     * @var bool $isModerator Indicates whether the player is a moderator.
     */
    private bool $isModerator;

    /**
     * Player constructor.
     *
     * @param int $id The unique identifier for the player.
     * @param string $username The username of the player.
     * @param string $email The email address of the player.
     * @param string $password The password of the player.
     * @param string|null $avatarUrl The URL of the player's avatar.
     * @param bool $isModerator Indicates whether the player is a moderator.
     */
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

    /**
     * Gets the unique identifier for the player.
     *
     * @return int The unique identifier for the player.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Gets the username of the player.
     *
     * @return string The username of the player.
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Gets the email address of the player.
     *
     * @return string The email address of the player.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Gets the password of the player.
     *
     * @return string The password of the player.
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Gets the URL of the player's avatar.
     *
     * @return string|null The URL of the player's avatar.
     */
    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    /**
     * Checks if the player is a moderator.
     *
     * @return bool True if the player is a moderator, false otherwise.
     */
    public function isModerator(): bool
    {
        return $this->isModerator;
    }

    // Setters

    /**
     * Sets the username of the player.
     *
     * @param string $username The new username of the player.
     * @return void
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * Sets the email address of the player.
     *
     * @param string $email The new email address of the player.
     * @return void
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Sets the password of the player.
     *
     * @param string $password The new password of the player.
     * @return void
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Sets the URL of the player's avatar.
     *
     * @param string|null $avatarUrl The new URL of the player's avatar.
     * @return void
     */
    public function setAvatarUrl(?string $avatarUrl): void
    {
        $this->avatarUrl = $avatarUrl;
    }

    /**
     * Sets the moderator status of the player.
     *
     * @param bool $isModerator The new moderator status of the player.
     * @return void
     */
    public function setModerator(bool $isModerator): void
    {
        $this->isModerator = $isModerator;
    }
}