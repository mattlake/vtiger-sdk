<?php

namespace Trunk\VtigerApi;

require_once __DIR__ . '/resources/RequestHandler.php';
require_once __DIR__ . '/resources/VtigerEntity.php';

use Psr\Http\Client\ClientInterface;
use Trunk\VtigerApi\Resources\RequestHandler;
use Trunk\VtigerApi\Resources\VtigerEntity;

class VtigerApi
{
    private static $instance;
    private $endpoint;
    private $sessionId;
    private $requestHandler;
    private $idPrefixCache = [];

    private function __construct(ClientInterface $client)
    {
        $this->requestHandler = new RequestHandler($client);
    }

    public static function getInstance(ClientInterface $client): self
    {
        if (empty(self::$instance)) {
            self::$instance = new VtigerApi($client);
        }

        return self::$instance;
    }

    public function setEndpoint(string $address = null): self
    {
        $this->endpoint = $address;
        return $this;
    }

    public function authenticate(string $username, string $secret): self
    {
        if (!isset($this->endpoint)) {
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

        $content = $this->requestHandler->get($this->endpoint, $params);

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

        $content = $this->requestHandler->post($this->endpoint, $data);

        if ($content['success'] == true) {
            return $content['result']['sessionName'];
        }

        throw new \Exception($content['error']['code'] . ': ' . $content['error']['message']);
    }

    public function logout(): void
    {
        $data = ['operation' => 'logout', 'sessionName' => $this->sessionId];
        $this->requestHandler->post($this->endpoint, $data);
    }

    public function getListTypes(): array
    {
        $data = ['operation' => 'listtypes', 'sessionName' => $this->sessionId];
        $content = $this->requestHandler->get($this->endpoint, $data);

        if ($content['success'] == true) {
            return $content['result'];
        }

        throw new \Exception($content['error']['code'] . ': ' . $content['error']['message']);
    }

    public function describeModule(string $moduleName): array
    {
        $data = ['operation' => 'describe', 'sessionName' => $this->sessionId, 'elementType' => $moduleName];
        $content = $this->requestHandler->get($this->endpoint, $data);

        if ($content['success'] != true) {
            throw new \Exception($content['error']['code'] . ': ' . $content['error']['message']);
        }

        // Add prefix ID to Cache
        $this->idPrefixCache[$moduleName] = $content['result']['idPrefix'];

        return $content['result'];
    }

    public function retrieve(string $moduleName, int $id)
    {
        $webserviceId = $this->buildWebserviceId($moduleName, $id);
        $data = ['operation' => 'retrieve', 'sessionName' => $this->sessionId, 'id' => $webserviceId];
        try {
            $content = $this->requestHandler->get($this->endpoint, $data);
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }

        if ($content['success'] != true) {
            throw new \Exception($content['error']['code'] . ': ' . $content['error']['message']);
        }

        return new VtigerEntity($moduleName, $content['result']);
    }

    public function buildWebserviceId(string $moduleName, int $id): string
    {
        if (!in_array($moduleName, $this->idPrefixCache)) {
            $this->describeModule($moduleName);
        }

        return $this->idPrefixCache[$moduleName] . 'x' . $id;
    }
}