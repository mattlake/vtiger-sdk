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
        $hash = $this->makeKey($token, $secret);

        echo $hash . PHP_EOL;
        return $this;
    }

    private function makeChallenge(string $username): string
    {
        $request = $this->client->createRequest('GET', $this->url . '/webservice.php?operation=getchallenge&username=' . $username);
        $response = $this->client->sendRequest($request);
        $content = json_decode($response->getBody()->getContents(), true);

        if ($content['success'] == false) {
            throw new \Exception($content['error']['code'] . ': ' . $content['error']['message']);
        }

        return $content['result']['token'];
    }

    private function makeKey(string $token, string $secret):string
    {
        return md5($token.$secret);
    }
}