<?php


require_once __DIR__.'/../src/VtigerApi.php';
require_once __DIR__.'/../vendor/autoload.php';

use Trunk\VtigerApi\VtigerApi;
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
    expect(VtigerApi::getInstance($this->container->get('Psr18Client')))->toBeInstanceof(VtigerApi::class);
});