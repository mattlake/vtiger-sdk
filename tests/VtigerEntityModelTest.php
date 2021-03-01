<?php

use Mockery\Mock;
use Trunk\VtigerSDK\Http\Models\VtigerEntityModel;
use Trunk\VtigerSDK\Http\VtigerResponse;

require_once __DIR__.'/../src/Http/Models/VtigerEntityModel.php';
require_once __DIR__.'/../src/Http/VtigerResponse.php';

it('can instantiate an empty model', function(){
    expect(new VtigerEntityModel())->toBeInstanceOf(VtigerEntityModel::class);
});

it('can be instantiated using createFromReponse() method', function(){

    $res = Mockery::instanceMock('Trunk\VtigerSDK\Http\VtigerResponse');
    $res->success = true;
    $res->responseArray['result'] = [
        'test' => 'pass',
        'int' => 123
    ];

    $result = VtigerEntityModel::createFromResponse($res);
    Mockery::close();
    expect($result->get('test'))->toBe('pass');
});

it('can get and set strings to the valueMap', function(){
    $entity = new VtigerEntityModel();
    $entity->set('testString', 'Test Value');
    expect($entity->get('testString'))->toBe('Test Value');
});

it('can get and set integers to the valueMap', function(){
    $entity = new VtigerEntityModel();
    $entity->set('testInt', 123);
    expect($entity->get('testInt'))->toBe(123);
});

it('can get and set booleans to the valueMap', function(){
    $entity = new VtigerEntityModel();
    $entity->set('testBool', true);
    expect($entity->get('testBool'))->toBe(true);
});

it('can get and set arrays to the valueMap', function(){
    $entity = new VtigerEntityModel();
    $entity->set('testArray', [1,2,3,4]);
    expect($entity->get('testArray'))->toBe([1,2,3,4]);
});

it('can get and set NULL to the valueMap', function(){
    $entity = new VtigerEntityModel();
    $entity->set('testNull', null);
    expect($entity->get('testNull'))->toBe(null);
});