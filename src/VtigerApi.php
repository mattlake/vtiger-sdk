<?php

namespace Trunk\VtigerApi;

class VtigerApi
{
    private static $instance;
    private $url;
    private $accessToken;

    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function url(string $address = null)
    {
        if (is_null($address)) {
            return self::getInstance()->url;
        }

        self::getInstance()->url = $address;
        return self::$instance;
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