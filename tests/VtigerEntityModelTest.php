<?php

require_once __DIR__.'/../src/Http/VtigerEntityModel.php';

it('can instantiate an empty model', function(){
    expect(new \Trunk\VtigerSDK\Http\VtigerEntityModel())->toBeInstanceOf(\Trunk\VtigerSDK\Http\VtigerEntityModel::class);
});

it('can get and set strings to the valueMap', function(){
    $entity = new \Trunk\VtigerSDK\Http\VtigerEntityModel();
    $entity->set('testString', 'Test Value');
    expect($entity->get('testString'))->toBe('Test Value');
});

it('can get and set integers to the valueMap', function(){
    $entity = new \Trunk\VtigerSDK\Http\VtigerEntityModel();
    $entity->set('testInt', 123);
    expect($entity->get('testInt'))->toBe(123);
});

it('can get and set booleans to the valueMap', function(){
    $entity = new \Trunk\VtigerSDK\Http\VtigerEntityModel();
    $entity->set('testBool', true);
    expect($entity->get('testBool'))->toBe(true);
});

it('can get and set arrays to the valueMap', function(){
    $entity = new \Trunk\VtigerSDK\Http\VtigerEntityModel();
    $entity->set('testArray', [1,2,3,4]);
    expect($entity->get('testArray'))->toBe([1,2,3,4]);
});

it('can get and set NULL to the valueMap', function(){
    $entity = new \Trunk\VtigerSDK\Http\VtigerEntityModel();
    $entity->set('testNull', null);
    expect($entity->get('testNull'))->toBe(null);
});