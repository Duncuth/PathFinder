<?php

// TEST !!
require __DIR__ . '/vendor/autoload.php';

use gateways\GatewayPlayer;
use classes\Player;

try {
    // Créer une instance de GatewayPlayer
    $playerGateway = new GatewayPlayer();

    // Ajouter un nouveau joueur
    $newPlayerData = [
        'username' => 'azarka',
        'email' => 'azarka@example.com',
        'password' => 'test', // Le mot de passe sera haché dans la Gateway
        'avatar_url' => 'https://example.com/avatar.png',
        'is_moderator' => false
    ];
    $playerGateway->addPlayer($newPlayerData);
    echo "Player 'azarka' added successfully.\n";

}
catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}