<?php

namespace Trunk\VtigerSDK\Http;

use Psr\Http\Message\ResponseInterface;
use Trunk\VtigerSDK\Http\Models\VtigerEntityModel;

require_once __DIR__.'/BaseResponse.php';
require_once __DIR__.'/VtigerResponse.php';
require_once __DIR__.'/Models/VtigerEntityModel.php';

class ResponseHandler
{
    /**
     * method that handles the response types and creates the required objects
     * @param string $responseClass
     * @param ResponseInterface $response
     * @return VtigerEntityModel|VtigerResponse
     */
    public static function handle(string $responseClass, array $response)
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