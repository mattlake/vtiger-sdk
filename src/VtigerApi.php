<?php

namespace Trunk\VtigerApi;

class VtigerApi
{
    private static $instance;
    private $url;
    private $accessToken;
    private $client;

    private function __construct($client)
    {
        $this->client = $client;
    }

    public static function getInstance($client): self
    {
        if (empty(self::$instance)) {
            self::$instance = new VtigerApi($client);
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

        $token = $this->makeChallenge($username);

        echo $token . PHP_EOL;
        return $this;
    }

    private function makeChallenge(string $username): string
    {
        $response = $this->client->request('GET', $this->url . '/webservice.php?operation=getchallenge&username=' . $username)->toArray();

        if ($response['success'] == false) {
            throw new \Exception($response['error']['code'] . ': ' . $response['error']['message']);
        }

        return $response['result']['token'];
    }
}