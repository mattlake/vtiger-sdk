<?php

declare(strict_types=1);

namespace Trunk\VtigerSDK;

use Exception;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpClient\Psr18Client;
use Trunk\VtigerSDK\Http\VtigerRequest;
use Trunk\VtigerSDK\Http\VtigerResponse;

require_once __DIR__ . '/Http/VtigerRequest.php';
require_once __DIR__ . '/Http/VtigerResponse.php';

class VtigerApi
{
    /**
     * Session Name used for authentication, populated by login method
     * @var string
     */
    private $sessionName;
    /**
     * The Vtiger Api endpoint
     * eg. https://www.yourvtigerinstance.com/webservice.php
     * @var string
     */
    private $endpoint;
    /**
     * @var Psr18Client
     */
    private $client;

    /**
     * VtigerApi constructor.
     * @param string $endpoint The Vtiger APi Endpoint
     */
    private function __construct(string $endpoint)
    {
        $this->endpoint = $endpoint;
        $this->client = new Psr18Client();
    }

    /**
     * Static method to create api instance and return
     * @param string $endpoint
     * @return VtigerApi
     */
    public static function endpoint(string $endpoint): VtigerApi
    {
        return new VtigerApi($endpoint);
    }

    /**
     * Parent method to cover the entire login process
     * @param string $username
     * @param string $secret
     * @return $this
     * @throws Exception|ClientExceptionInterface
     */
    public function login(string $username, string $secret): self
    {
        $token = $this->makeChallenge($username);
        $accessKey = $this->makeKey($token, $secret);
        $this->sessionName = $this->getSessionId($username, $accessKey);
        return $this;
    }

    /**
     * Initial API call to get the token used to create the accessKey
     * @param $username
     * @return string
     * @throws Exception|ClientExceptionInterface
     */
    private function makeChallenge($username): string
    {
        $request = VtigerRequest::get()
            ->withParameter('operation', 'getchallenge')
            ->withParameter('username', $username)
            ->return(VtigerResponse::class);

        $response = $this->execute($request);

        return $response->token;
    }

    /**
     * This method creates the access key needed to get the session ID
     * @param string $token
     * @param string $secret
     * @return string
     */
    private function makeKey(string $token, string $secret): string
    {
        return md5($token . $secret);
    }

    /**
     * This method generate the session id that is needed for all subsequent API requests
     * @param string $username
     * @param string $accessKey
     * @return string
     * @throws Exception|ClientExceptionInterface
     */
    private function getSessionId(string $username, string $accessKey): string
    {
        $request = VtigerRequest::post()
            ->withParameter('operation', 'login')
            ->withParameter('username', $username)
            ->withParameter('accessKey', $accessKey)
            ->return(VtigerResponse::class);

        $response = $this->execute($request);

        return $response->sessionName;
    }

    public function getSessionName():string
    {
        return $this->sessionName;
    }

    public function getListTypes(): VtigerResponse
    {
        $req = VtigerRequest::get()
            ->withParameter('sessionName', $this->sessionName)
            ->withParameter('operation', 'listtypes')
            ->return(VtigerResponse::class);

        return $this->execute($req);
    }

    /**
     * Method that executes a Vtiger APi request
     * @param VtigerRequest $request
     * @return mixed
     * @throws Exception
     * @throws ClientExceptionInterface
     */
    public function execute(VtigerRequest $request)
    {
        switch ($request->getRequestType()) {
            case 'GET':
                $response = $this->getRequest($request);
                break;
            case 'POST':
                $response = $this->postRequest($request);
                break;
            default:
                throw new Exception('Unknown request type');
        }

        $responseClass = $request->getReturnType();
        return new $responseClass($response);
    }

    /**
     * Method that handles the get request branch
     * @param VtigerRequest $request
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    private function getRequest(VtigerRequest $request): ResponseInterface
    {
        $params = http_build_query($request->getParameters());

        $req = $this->client->createRequest('GET', $this->endpoint . '?' . $params);
        return $this->client->sendRequest($req);
    }

    /**
     * Method that handles the post request branch
     * @param VtigerRequest $request
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function postRequest(VtigerRequest $request): ResponseInterface
    {
        $body = $this->client->createStream(http_build_query($request->getParameters()));

        $req = $this->client->createRequest('POST', $this->endpoint)
            ->withHeader('Content-Type', 'application/x-www-form-urlencoded')
            ->withBody($body);

        return $this->client->sendRequest($req);
    }
}