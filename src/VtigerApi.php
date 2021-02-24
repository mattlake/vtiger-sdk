<?php

namespace Trunk\VtigerApi;

require_once __DIR__.'/resources/RequestHandler.php';

use Psr\Http\Client\ClientInterface;
use Trunk\VtigerApi\Resources\RequestHandler;

class VtigerApi
{
    private static $instance;
    private $url;
    private $sessionId;
    private $client;
    private $requestHandler;

    private function __construct(ClientInterface $client)
    {
        $this->client = $client;
        $this->requestHandler = new RequestHandler($client);
    }

    public static function getInstance(ClientInterface $client): self
    {
        if (empty(self::$instance)) {
            self::$instance = new VtigerApi($client);
        }

        return self::$instance;
    }

    public function setUrl(string $address = null): self
    {
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
        $params = [
            'operation' => 'getchallenge',
            'username' => $username
        ];

        $content = $this->requestHandler->get($this->url, $params);

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

        $content = $this->requestHandler->post($this->url, $data);

        if ($content['success'] == true) {
            return $content['result']['sessionName'];
        }

        throw new \Exception($content['error']['code'] . ': ' . $content['error']['message']);
    }
}