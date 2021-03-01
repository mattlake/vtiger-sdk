<?php

require_once __DIR__ . '/../src/VtigerApi.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Trunk\VtigerSDK\Http\VtigerRequest;
use Trunk\VtigerSDK\Http\VtigerResponse;

it(
    'can create from constructor - GET',
    function () {
        $testClass = new VtigerRequest('GET');
        expect($testClass)->toBeInstanceOf(VtigerRequest::class);
        expect($testClass->getRequestType())->toBe('GET');
    }
);

it(
    'can create from constructor - POST',
    function () {
        $testClass = new VtigerRequest('POSt');
        expect($testClass)->toBeInstanceOf(VtigerRequest::class);
        expect($testClass->getRequestType())->toBe('POST');
    }
);

it(
    'can create from constructor with mismatched case - GET',
    function () {
        $testClass = new VtigerRequest('gEt');
        expect($testClass)->toBeInstanceOf(VtigerRequest::class);
        expect($testClass->getRequestType())->toBe('GET');
    }
);

it(
    'can create from constructor with mismatched case - POST',
    function () {
        $testClass = new VtigerRequest('POst');
        expect($testClass)->toBeInstanceOf(VtigerRequest::class);
        expect($testClass->getRequestType())->toBe('POST');
    }
);

it(
    'throws an exception if invalid request type used',
    function () {
        new VtigerRequest('PATCH');
    }
)->throws(Exception::class);

it(
    'can be instantiated using ::get()',
    function () {
        $testClass = VtigerRequest::get();
        expect($testClass)->toBeInstanceOf(VtigerRequest::class);
        expect($testClass->getRequestType())->toBe('GET');
    }
);

it(
    'can be instantiated using ::post()',
    function () {
        $testClass = VtigerRequest::post();
        expect($testClass)->toBeInstanceOf(VtigerRequest::class);
        expect($testClass->getRequestType())->toBe('POST');
    }
);

it(
    'can get and set request parameters',
    function () {
        $testClass = VtigerRequest::get()->withParameter('testing', 'is the best');
        expect($testClass->getParameters())->toBe(['testing' => 'is the best']);
    }
);

it(
    'can get and set return type',
    function () {
        $testClass = VtigerRequest::get()->return(VtigerResponse::class);
        expect($testClass->getReturnType())->toBe(VtigerResponse::class);
    }
);

it(
    'throws an exception if an invalid return type is set',
    function () {
        VtigerRequest::get()->return(Garbage::class);
    }
)->throws(Exception::class);

