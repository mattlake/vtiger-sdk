<?php

namespace Trunk\VtigerApi;

class VtigerApi
{
    private static $instance;
    private $url;
    private $sessionId;
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
        $this->sessionId = $this->getSessionId($username, $hash);
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

    private function makeKey(string $token, string $secret): string
    {
        return md5($token . $secret);
    }

    private function getSessionId(string $username, string $accessKey): string
    {
        $data = [
            'operation' => 'login',
            'username' => $username,
            'accessKey' => $accessKey
        ];

        $body = $this->client->createStream($this->convertArrayParamsToString($data));

        $request = $this->client->createRequest('POST', $this->url . '/webservice.php')
            ->withHeader('Content-Type', 'application/x-www-form-urlencoded')
            ->withBody($body);

        $response = $this->client->sendRequest($request);

        $content = json_decode($response->getBody()->getContents(), true);

        if ($content['success'] == true) {
            return $content['result']['sessionName'];
        }

        throw new \Exception($content['error']['code'] . ': ' . $content['error']['message']);
    }

    private function convertArrayParamsToString(array $params): string
    {
        $string = '';
        foreach ($params as $key => $value) {
            $string .= $key . '=' . $value . '&';
        }
        return $string;
    }
}