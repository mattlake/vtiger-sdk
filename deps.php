<?php

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use function DI\create;

return [
    'Psr18Client' => function () {
        return new \Symfony\Component\HttpClient\Psr18Client();
    },
];