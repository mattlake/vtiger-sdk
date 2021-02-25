<?php

namespace Trunk\VtigerApi\Resources;

class VtigerApiResponse
{
    public $success = false;
    public $errorCode = null;
    public $errorMessage = null;


    public function __construct($response) {
        $this->success = $response['success'];

        if ($this->success == false) {
            $this->errorCode = $response['error']['code'];
            $this->errorMessage = $response['error']['message'];
            return;
        }

        foreach($response['result'] as $k => $v) {
            $this->$k = $v;
        }
    }
}