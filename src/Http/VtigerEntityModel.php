<?php

namespace Trunk\VtigerSDK\Http;

use Psr\Http\Message\ResponseInterface;

class VtigerEntityModel
{
    /**
     * Array of the populate fields for the Entity
     * @var array
     */
    private $valueMap = [];

    /**
     * VtigerEntityModel constructor.
     * @param ResponseInterface|null $response
     */
    public function __construct()
    {
        //
    }

    /**
     * method to populate an Entity Model with data from the API response
     * @param VtigerResponse $response
     * @return VtigerEntityModel
     */
    public static function createFromResponse(VtigerResponse $response): VtigerEntityModel
    {
        $entity = new VtigerEntityModel();
        foreach ($response->responseArray['result'] as $k => $v) {
            $entity->valueMap[$k] = $v;
        }
        return $entity;
    }

    /**
     * method to retrieve a value from the value map
     * @param string $field
     * @return mixed|null
     */
    public function get(string $field)
    {
        return $this->valueMap[$field] ?? null;
    }

    /**
     * method to write a value to the value map
     * @param string $fieldName
     * @param $value
     * @return $this
     */
    public function set(string $fieldName, $value): self
    {
        $this->valueMap[$fieldName] = $value;
        return $this;
    }
}