<?php

namespace Trunk\VtigerSDK\Http;

use Psr\Http\Message\ResponseInterface;

class VtigerResponse
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
        $res = $this->parseData($response);

        if (!empty($res)) {
            $this->success = $res['success'];

            if ($this->success == false) {
                $this->errorCode = $res['error']['code'];
                $this->errorMessage = $res['error']['message'];
                return;
            }

            foreach ($res['result'] as $k => $v) {
                $this->$k = $v;
            }
        }
    }

    // TODO this should be in an array or parent class
    /**
     * Convert PSR7 response to associative array
     * @param ResponseInterface $response
     * @return array
     */
    private function parseData(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true) ?? [];
    }
}