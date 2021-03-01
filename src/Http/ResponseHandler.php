<?php

namespace Trunk\VtigerSDK\Http;

use Psr\Http\Message\ResponseInterface;

require_once __DIR__.'/BaseResponse.php';
require_once __DIR__.'/VtigerResponse.php';

class ResponseHandler
{
    public static function handle(string $responseClass, ResponseInterface $response)
    {
        return new $responseClass($response);
    }
}