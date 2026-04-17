<?php

namespace src;

use GuzzleHttp\Client;
use src\Interfaces\HttpClientInterface;

class HttpClient implements HttpClientInterface
{
    /**
     * construct the http client
     *
     * @param Client $client
     */
    public function __construct(
        private Client $client
    ) {}

    /**
     * send a request to the API and return the response body as a string.
     *
     * @param string $method
     * @param string $url
     * @param array<string, mixed> $data
     * @return string
     */
    public function request(string $method, string $url, array $data = []): string
    {
        try {
            $response = $this->client->request($method, $url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($data),
            ]);

            if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
                throw new \RuntimeException(
                    sprintf('Request failed with status %d', $response->getStatusCode())
                );
            }
            return $response->getBody()->getContents();
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            throw new \RuntimeException(
                sprintf('HTTP %s %s failed: %s', $method, $url, $e->getMessage()),
                0,
                $e
            );
        }
    }
}
