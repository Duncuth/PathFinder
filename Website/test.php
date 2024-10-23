<?php

//TEST !!
require __DIR__ . '/vendor/autoload.php';
use gateways\PlayerGateway;


$playerGateway = new PlayerGateway();
$playerGateway->createPlayer("azarka", "test");