<?php

namespace Trunk\VtigerSDK\Http;

use Psr\Http\Message\ResponseInterface;

class VtigerResponse extends BaseResponse
{
    /**
     * Success status of the response
     * @var bool|mixed
     */
    public $success = false;
    /**
     * Error code returned from the APi (If there was one)
     * @var mixed|null
     */
    public $errorCode = null;
    /**
     * Error message returned from the APi (If there was one)
     * @var mixed|null
     */
    public $errorMessage = null;

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