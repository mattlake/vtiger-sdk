<?php

declare(strict_types=1);

namespace Trunk\VtigerSDK\Http;

use Exception;

class VtigerRequest
{
    /**
     * Current supported request types are GET & POST
     * @var string
     */
    private $requestType;
    /**
     * Parameters to be included with the request
     * @var array
     */
    private $parameters = [];
    /**
     * Desired reponse class
     * @var string
     */
    private $returnType = 'VtigerResponse';

    /**
     * VtigerRequest constructor.
     * @param string $requestType
     * @throws Exception
     */
    public function __construct(string $requestType)
    {
        if (!in_array(strtoupper($requestType), ['GET', 'POST'])) {
            throw new Exception('Invalid request type');
        }

        $this->requestType = strtoupper($requestType);
    }

    /**
     * Return request type
     * @return string
     */
    public function getRequestType(): string
    {
        return $this->requestType;
    }

    /**
     * GET request static constructor
     * @return VtigerRequest
     */
    public static function get(): VtigerRequest
    {
        return new VtigerRequest('GET');
    }

    /**
     * Post request static constructor
     * @return VtigerRequest
     */
    public static function post(): VtigerRequest
    {
        return new VtigerRequest('POST');
    }

    /**
     * method to add parameter to request
     * @param string $key
     * @param $value
     * @return $this
     */
    public function withParameter(string $key, $value): self
    {
        $this->parameters[$key] = $value;
        return $this;
    }

    /**
     * method to return a list of the parameters attached to the request
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * method to set the desired return type
     * @param string $responseClass
     * @return $this
     * @throws Exception
     */
    public function return(string $responseClass): self
    {
        if (!class_exists($responseClass)) {
            throw new Exception('Return Type not valid');
        }

        $this->returnType = $responseClass;
        return $this;
    }

    /**
     * method to return the desired return type
     * @return string
     */
    public function getReturnType(): string
    {
        return $this->returnType;
    }
}