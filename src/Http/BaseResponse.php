<?php

namespace Trunk\VtigerSDK\Http;

use Psr\Http\Message\ResponseInterface;

class BaseResponse
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
     * Associative array of the response data for access by child classes
     * @var array
     */
    public $responseArray = [];

    /**
     * BaseResponse constructor.
     * @param ResponseInterface $response
     */
    public function __construct(array $response){
        $this->responseArray = $response;

        if (!empty($this->responseArray)) {
            $this->success = $this->responseArray['success'];

            if ($this->success == false) {
                $this->errorCode = $this->responseArray['error']['code'];
                $this->errorMessage = $this->responseArray['error']['message'];
                return;
            }
        }
    }
}