<?php

namespace models;

use gateways\AdministratorGateway;
use classes\Administrator;

/**
 * Class AdministratorModel
 *
 * Provides methods to manage administrators, including adding, verifying, retrieving, updating, and deleting administrators.
 */
class AdministratorModel
{
    /**
     * @var AdministratorGateway $gwAdministrator The gateway for administrator data operations.
     */
    private $gwAdministrator;

    /**
     * AdministratorModel constructor.
     *
     * Initializes the AdministratorGateway.
     */
    public function __construct()
    {
        $this->gwAdministrator = new AdministratorGateway();
    }

    /**
     * Add a new administrator.
     *
     * @param array $adminData The data of the administrator to add.
     * @return void
     */
    public function addAdministrator($adminData)
    {
        $this->gwAdministrator->addAdministrator($adminData);
    }

    /**
     * Verify the credentials of an administrator.
     *
     * @param array $adminData The credentials of the administrator to verify.
     * @return int|null The ID of the administrator if verified, null otherwise.
     */
    public function verifyAdministrator(array $adminData): ?int
    {
        return $this->gwAdministrator->verifyAdmin($adminData);
    }

    /**
     * Retrieve an administrator by ID.
     *
     * @param int $id The ID of the administrator to retrieve.
     * @return Administrator|null The administrator object if found, null otherwise.
     */
    public function getAdministratorById($id): ?Administrator
    {
        $adminData = $this->gwAdministrator->getAdministratorById($id);
        if ($adminData) {
            return new Administrator(
                $adminData['id'],
                $adminData['username'],
                $adminData['password']
            );
        }
        return null;
    }

    /**
     * Retrieve an administrator by username.
     *
     * @param string $username The username of the administrator to retrieve.
     * @return Administrator|null The administrator object if found, null otherwise.
     */
    public function getAdministratorByUsername($username): ?Administrator
    {
        $adminData = $this->gwAdministrator->getAdministratorByUsername($username);
        if ($adminData) {
            return new Administrator(
                $adminData['id'],
                $adminData['username'],
                $adminData['password']
            );
        }
        return null;
    }

    /**
     * Update an administrator.
     *
     * @param int $id The ID of the administrator to update.
     * @param array $adminData The new data for the administrator.
     * @return void
     */
    public function updateAdministrator($id, $adminData)
    {
        $this->gwAdministrator->updateAdministrator($id, $adminData);
    }

    /**
     * Delete an administrator by ID.
     *
     * @param int $id The ID of the administrator to delete.
     * @return void
     */
    public function deleteAdministrator($id)
    {
        $this->gwAdministrator->deleteAdministrator($id);
    }

    /**
     * Retrieve all administrators.
     *
     * @return array The list of all administrators.
     */
    public function getAllAdministrators(): array
    {
        $adminData = $this->gwAdministrator->getAllAdministrators();
        $admins = [];
        foreach ($adminData as $admin) {
            $admins[] = new Administrator(
                $admin['id'],
                $admin['username'],
                $admin['password']
            );
        }
        return $admins;
    }
}