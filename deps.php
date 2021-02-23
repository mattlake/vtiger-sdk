<?php

use function DI\create;
use Symfony\Component\HttpClient\HttpClient;

return [
    'HttpClient' => function () {
        return HttpClient::create();
    },
];