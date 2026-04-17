<?php

declare(strict_types=1);

namespace src\Interfaces;

/**
 * Interface for classes that can make HTTP requests.
 */
interface HttpClientInterface
{
    /**
     * make an HTTP request and return the response body as a string.
     *
     * @param string $method
     * @param string $url
     * @param array<string, mixed> $data
     * @return string
     */
    public function request(string $method, string $url, array $data = []): string;
}
