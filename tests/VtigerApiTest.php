<?php

require_once __DIR__ . '/../src/VtigerApi.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Trunk\VtigerSDK\VtigerApi;
use DI\ContainerBuilder;

beforeEach(function(){
    // Create Dependency Injection Container
    $containerBuilder = new ContainerBuilder();
    $containerBuilder->addDefinitions(__DIR__ . '/../deps.php');
    $this->container = $containerBuilder->build();
});

afterEach(function(){
    unset($this->container);
});

it('can get instance', function(){
    expect(VtigerApi::endpoint('https://www.endpoint.com'))->toBeInstanceof(VtigerApi::class);
});