<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class HostIsReachableTest extends TestCase
{
    /**
     * @var string
     */
    const BASE_URL = 'https://dummyjson.com/';
    /**
     * @var Client
     */
    private Client $guzzleClient;

    /**
     * setup the test environment
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->guzzleClient = new GuzzleHttp\Client();
    }

    /**
     * test that the service is reachable
     *
     * @return void
     */
    public function test_host_is_reachable(): void
    {
        $response = $this->guzzleClient->request('GET', self::BASE_URL . 'http/200');

        $this->assertEquals(200, $response->getStatusCode());
    }
}
