<?php

namespace Trunk\VtigerSDK\Http;

use Psr\Http\Message\ResponseInterface;

class VtigerResponse extends BaseResponse
{
    /**
     * VtigerResponse constructor.
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);

        foreach ($this->responseArray['result'] as $k => $v) {
            $this->$k = $v;
        }
    }
}