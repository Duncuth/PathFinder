<?php

namespace classes;

/**
 * Class Administrator
 *
 * Represents an administrator with an ID, username, and password.
 */
class Administrator
{
    /**
     * @var int $id The unique identifier for the administrator.
     */
    private int $id;

    /**
     * @var string $username The username of the administrator.
     */
    private string $username;

    /**
     * @var string $password The password of the administrator.
     */
    private string $password;

    /**
     * Administrator constructor.
     *
     * @param int $id The unique identifier for the administrator.
     * @param string $username The username of the administrator.
     * @param string $password The password of the administrator.
     */
    public function __construct(int $id, string $username, string $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Get the ID of the administrator.
     *
     * @return int The unique identifier for the administrator.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the username of the administrator.
     *
     * @return string The username of the administrator.
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Get the password of the administrator.
     *
     * @return string The password of the administrator.
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the username of the administrator.
     *
     * @param string $username The new username of the administrator.
     * @return void
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * Set the password of the administrator.
     *
     * @param string $password The new password of the administrator.
     * @return void
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}