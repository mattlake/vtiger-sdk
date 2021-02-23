<?php

require_once __DIR__.'/../src/VtigerApi.php';
use Trunk\VtigerApi\VtigerApi;

it('can get instance', function(){
    expect(VtigerApi::getInstance())->toBeInstanceof(VtigerApi::class);
});

it('can create instance through ::url method', function(){
    expect(VtigerApi::url('https://test.com'))->toBeInstanceOf(VtigerApi::class);
});

it('can get and set url', function(){
    $api = VtigerApi::getInstance();
    $api::url('https://test');
    expect(VtigerApi::url())->toBe('https://test');
    unset($api);
});