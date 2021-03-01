<?php

namespace Trunk\VtigerSDK\Http;

use Psr\Http\Message\ResponseInterface;

// TODO this feels like it is doing to much, The entity should probably be seperate from the response

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
    public function __construct(ResponseInterface $response = null)
    {
        if (is_null($response)) {
            return;
        }

        $res = $this->parseData($response);

        if (!empty($res)) {
            if ($res['success'] == false) {
                $this->errorCode = $res['error']['code'];
                $this->errorMessage = $res['error']['message'];
                return;
            }

            foreach ($res['result'] as $k => $v) {
                $this->valueMap[$k] = $v;
            }
        }
    }

    // TODO this should be in a trait or parent class
    /**
     * Method to convert response to Assoc array
     * @param ResponseInterface $response
     * @return array
     */
    private function parseData(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true) ?? [];
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