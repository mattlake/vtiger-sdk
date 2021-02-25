<?php

namespace Trunk\VtigerApi\Resources;

class VtigerEntity
{
    private $module;
    private $data;

    public function __construct(string $module, array $data = [])
    {
        $this->module = $module;

        if (count($data) > 0) {
            foreach ($data as $fieldName => $value) {
                $this->data[$fieldName] = $value;
            }
        }
    }
}