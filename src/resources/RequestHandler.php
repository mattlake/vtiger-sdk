<?php

namespace Trunk\VtigerApi\Resources;

use Psr\Http\Client\ClientInterface;

class RequestHandler
{
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function get(string $url, array $data): array
    {
        $params = http_build_query($data);

        $request = $this->client->createRequest('GET', $url . '/webservice.php' . '?' . $params);
        $response = $this->client->sendRequest($request);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function post(string $url, array $options): array
    {
        $body = $this->client->createStream(http_build_query($options));

        $request = $this->client->createRequest('POST', $url . '/webservice.php')
            ->withHeader('Content-Type', 'application/x-www-form-urlencoded')
            ->withBody($body);

        $response = $this->client->sendRequest($request);

        return json_decode($response->getBody()->getContents(), true);
    }
}
