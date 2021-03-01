<?php

// Include config file that contains login credentials
require_once './config.php';
require_once './vendor/autoload.php';
require_once __DIR__ . '/src/VtigerApi.php';

use Trunk\VtigerSDK\VtigerApi;
use DI\ContainerBuilder;

// Create Dependency Injection Container
$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/deps.php');
$container = $containerBuilder->build();

// Login to APi
$api = VtigerApi::endpoint(config::API_ENDPOINT)->login(config::USERNAME, config::SECRET);

// Get list types
$account = $api->getRecord('Accounts', 62856);
echo $account->get('accountname');

$ticket = new \Trunk\VtigerSDK\Http\VtigerEntityModel();