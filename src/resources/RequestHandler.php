<?php

namespace Trunk\VtigerApi\Resources;

use Psr\Http\Client\ClientInterface;

class RequestHandler
{
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function get(string $endpoint, array $data = []): VtigerApiResponse
    {
        $params = http_build_query($data);

        $request = $this->client->createRequest('GET', $endpoint . '?' . $params);
        $response = $this->client->sendRequest($request);

        return new VtigerApiResponse(json_decode($response->getBody()->getContents(), true));
    }

    public function post(string $endpoint, array $options = []): VtigerApiResponse
    {
        $body = $this->client->createStream(http_build_query($options));

        $request = $this->client->createRequest('POST', $endpoint)
            ->withHeader('Content-Type', 'application/x-www-form-urlencoded')
            ->withBody($body);

        $response = $this->client->sendRequest($request);

        return new VtigerApiResponse(json_decode($response->getBody()->getContents(), true));
    }
}
