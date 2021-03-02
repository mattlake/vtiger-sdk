<?php

require_once __DIR__ . '/../src/VtigerApi.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Trunk\VtigerSDK\Http\VtigerRequest;
use Trunk\VtigerSDK\VtigerApi;


it('can get instance using ::endpoint() method', function(){
    expect(VtigerApi::endpoint('https://www.endpoint.com', new \Symfony\Component\HttpClient\Psr18Client()))->toBeInstanceof(VtigerApi::class);
});