<?php


require_once __DIR__.'/../src/VtigerApi.php';
use Trunk\VtigerApi\VtigerApi;

it('can get instance', function(){
    expect(VtigerApi::getInstance())->toBeInstanceof(VtigerApi::class);
});

it('can get and set url', function(){
    $api = VtigerApi::getInstance();
    $api->url('https://test');
    expect($api->url())->toBe('https://test');
    unset($api);
});