<?php

use function DI\create;
use Symfony\Component\HttpClient\Psr18Client;

return [
    'Psr18Client' => function () {
        return new Psr18Client();
    },
];