<?php

namespace models;

use gateways\AdministratorGateway;
use classes\Administrator;

class AdministratorModel
{
    private $gwAdministrator;

    public function __construct()
    {
        $this->gwAdministrator = new AdministratorGateway();
    }

    // Ajouter un administrateur
    public function addAdministrator($adminData)
    {
        $this->gwAdministrator->addAdministrator($adminData);
    }

    // Vérifier les identifiants d'un administrateur
    public function verifyAdministrator($adminData): ?int
    {
        return $this->gwAdministrator->verifyAdministrator($adminData);
    }

    // Récupérer un administrateur par ID
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

    // Récupérer un administrateur par username
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

    // Mettre à jour un administrateur
    public function updateAdministrator($id, $adminData)
    {
        $this->gwAdministrator->updateAdministrator($id, $adminData);
    }

    // Supprimer un administrateur par ID
    public function deleteAdministrator($id)
    {
        $this->gwAdministrator->deleteAdministrator($id);
    }
}
