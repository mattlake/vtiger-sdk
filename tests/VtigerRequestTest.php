<?php

require_once __DIR__.'/../src/VtigerApi.php';
require_once __DIR__.'/../vendor/autoload.php';

use Trunk\VtigerSDK\VtigerApi;
use DI\ContainerBuilder;

it('can create from constructor - GET', function(){
    $testClass = new \Trunk\VtigerSDK\Http\VtigerRequest('GET');
    expect($testClass)->toBeInstanceOf(\Trunk\VtigerSDK\Http\VtigerRequest::class);
    expect($testClass->getRequestType())->toBe('GET');
});

it('can create from constructor - POST', function(){
    $testClass = new \Trunk\VtigerSDK\Http\VtigerRequest('POSt');
    expect($testClass)->toBeInstanceOf(\Trunk\VtigerSDK\Http\VtigerRequest::class);
    expect($testClass->getRequestType())->toBe('POST');
});

it('can create from constructor with mismatched case - GET', function(){
    $testClass = new \Trunk\VtigerSDK\Http\VtigerRequest('gEt');
    expect($testClass)->toBeInstanceOf(\Trunk\VtigerSDK\Http\VtigerRequest::class);
    expect($testClass->getRequestType())->toBe('GET');
});

it('can create from constructor with mismatched case - POST', function(){
    $testClass = new \Trunk\VtigerSDK\Http\VtigerRequest('POst');
    expect($testClass)->toBeInstanceOf(\Trunk\VtigerSDK\Http\VtigerRequest::class);
    expect($testClass->getRequestType())->toBe('POST');
});

it('can be instantiated using ::get()', function(){
    $testClass = \Trunk\VtigerSDK\Http\VtigerRequest::get();
    expect($testClass)->toBeInstanceOf(\Trunk\VtigerSDK\Http\VtigerRequest::class);
    expect($testClass->getRequestType())->toBe('GET');
});

it('can be instantiated using ::post()', function(){
    $testClass = \Trunk\VtigerSDK\Http\VtigerRequest::post();
    expect($testClass)->toBeInstanceOf(\Trunk\VtigerSDK\Http\VtigerRequest::class);
    expect($testClass->getRequestType())->toBe('POST');
});

it('can get and set request paramters', function(){
    $testClass = \Trunk\VtigerSDK\Http\VtigerRequest::get()->withParameter('testing','is the best');
    expect($testClass->getParameters())->toBe(['testing'=>'is the best']);
});

it('can get and set return type', function(){
    $testClass = \Trunk\VtigerSDK\Http\VtigerRequest::get()->return(\Trunk\VtigerSDK\Http\VtigerResponse::class);
    expect($testClass->getReturnType())->toBe(\Trunk\VtigerSDK\Http\VtigerResponse::class);
});

