<?php

namespace Trunk\VtigerSDK\Http;

use Psr\Http\Message\ResponseInterface;

class VtigerResponse
{
    public $success = false;
    public $errorCode = null;
    public $errorMessage = null;

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

    private function parseData(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true) ?? [];
    }
}