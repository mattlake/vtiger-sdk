<?php

namespace Trunk\VtigerApi;

use Symfony\Component\HttpClient\Psr18Client;

class VtigerApi
{
    private static $instance;
    private $url;
    private $accessToken;

    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        if (empty(self::$instance)) {
            self::$instance = new VtigerApi();
        }

        return self::$instance;
    }

    public function url(string $address = null)
    {
        if (is_null($address)) {
            return $this->url;
        }

        $this->url = $address;
        return $this;
    }

    public function authenticate(string $username, string $secret): self
    {
        if (!isset($this->url)) {
            throw new \Exception('URL not set');
        }

        $this->accessToken = $this->getAccessToken($username, $secret);
        return $this;
    }

    private function getAccessToken(string $username, string $secret): string
    {
        return 'Placeholder';
    }
}