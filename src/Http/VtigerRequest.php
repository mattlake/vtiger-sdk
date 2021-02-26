<?php

declare(strict_types=1);

namespace Trunk\VtigerSDK\Http;

use Exception;

class VtigerRequest
{
    private $requestType;
    private $parameters = [];
    private $returnType = 'VtigerResponse';

    public function __construct(string $requestType)
    {
        if (!in_array(strtoupper($requestType), ['GET', 'POST'])) {
            throw new Exception('Invalid request type');
        }

        $this->requestType = strtoupper($requestType);
    }

    public function getRequestType(): string
    {
        return $this->requestType;
    }

    public static function get(): VtigerRequest
    {
        return new VtigerRequest('GET');
    }

    public static function post(): VtigerRequest
    {
        return new VtigerRequest('POST');
    }

    public function withParameter(string $key, $value): self
    {
        $this->parameters[$key] = $value;
        return $this;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function return(string $responseClass): self
    {
        if (!class_exists($responseClass)) {
            throw new Exception('Return Type not valid');
        }

        $this->returnType = $responseClass;
        return $this;
    }

    public function getReturnType(): string
    {
        return $this->returnType;
    }
}