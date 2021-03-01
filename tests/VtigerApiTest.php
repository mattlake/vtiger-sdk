<?php

require_once __DIR__ . '/../src/VtigerApi.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Trunk\VtigerSDK\VtigerApi;


it('can get instance using ::endpoint() method', function(){
    expect(VtigerApi::endpoint('https://www.endpoint.com'))->toBeInstanceof(VtigerApi::class);
});

it('can make challenge', function(){
    $mock = Mockery::mock(VtigerApi::class);
    $mock->shouldReceive('login')->andReturn($mock);
    $api = $mock->login('user','password');

});