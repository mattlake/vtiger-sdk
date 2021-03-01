<?php

namespace Trunk\VtigerSDK\Http;

use Psr\Http\Message\ResponseInterface;

require_once __DIR__.'/BaseResponse.php';
require_once __DIR__.'/VtigerResponse.php';

class ResponseHandler
{
    /**
     * method that handles the response types and creates the required objects
     * @param string $responseClass
     * @param ResponseInterface $response
     * @return VtigerEntityModel|VtigerResponse
     */
    public static function handle(string $responseClass, ResponseInterface $response)
    {
        $resp = new VtigerResponse($response);

        if($resp->success == false) {
            return $resp;
        }

        if($responseClass == VtigerResponse::class) {
            return $resp;
        }

        if($responseClass == VtigerEntityModel::class) {
            return VtigerEntityModel::createFromResponse($resp);
        }

        return $resp;
    }
}