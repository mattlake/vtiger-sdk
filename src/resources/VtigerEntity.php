<?php

namespace Trunk\VtigerApi\Resources;

class VtigerEntity
{
    private $module;
    private $data;

    public function __construct(string $module, $data)
    {
        $this->module = $module;

        if (empty($data)) {
            return;
        }

        foreach ($data as $fieldName => $value) {
            $this->data[$fieldName] = $value;
        }
    }
}