<?php

require_once __DIR__ . '/../src/VtigerApi.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Trunk\VtigerSDK\Http\VtigerRequest;
use Trunk\VtigerSDK\Http\VtigerResponse;

//it(
//    'can construct from psr7 response',
//    function () {
//        expect(new VtigerResponse(new \Nyholm\Psr7\Response()))->toBeInstanceOf(VtigerResponse::class);
//    }
//);
