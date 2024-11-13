<?php

//TEST !!
require __DIR__ . '/vendor/autoload.php';
use gateways\PlayerGateway;


$playerGateway = new PlayerGateway();
$playerGateway->createPlayer(array('username' => 'Kyllian', 'password' => 'mdp', 'email' => 'bgdu18@gmail.com'));