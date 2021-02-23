<?php

// Include config file that contains login credentials
require_once './config.php';
require_once './vendor/autoload.php';

use Trunk\VtigerApi\VtigerApi;
use DI\ContainerBuilder;

// Create Dependency Injection Container
$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/deps.php');
$container = $containerBuilder->build();

// Create APi Instance
$api = VtigerApi::getInstance($container->get('HttpClient'))
    ->url(config::BASE_URL)
    ->authenticate(config::USERNAME, config::SECRET);
