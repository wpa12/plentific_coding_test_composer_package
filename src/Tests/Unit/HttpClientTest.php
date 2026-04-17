<?php

declare(strict_types=1);

namespace src\Tests\Unit;

use PHPUnit\Framework\TestCase;
use src\HttpClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class HttpClientTest extends TestCase
{
    /**
     * @var HttpClient
     */
    private HttpClient $httpClient;
    /**
     * @var MockHandler
     */
    private MockHandler $mockGuzzleClientHandler;

    /**
     * setup the test environment
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->mockGuzzleClientHandler = new MockHandler([
            new Response(200, [], json_encode([
                'id' => 1,
                'firstName' => 'Wayne',
                'lastName' => 'Anstey',
                'email' => 'w.anstey@example.com',
            ], JSON_THROW_ON_ERROR)),
        ]);

        $mockStack = HandlerStack::create($this->mockGuzzleClientHandler);
        
        $mockClient = new Client([
            'handler' => $mockStack,
        ]);

        $this->httpClient = new HttpClient($mockClient);
    }

    /**
     * test that the http client can be instantiated
     *
     * @return void
     */
    public function test_http_client_can_be_instantiated(): void
    {
        $this->assertInstanceOf(HttpClient::class, $this->httpClient);
    }

    /**
     * test that the http client returns correct user data when requested by id
     *
     * @return void
     */
    public function test_http_client_returns_correct_user_data_when_requested_by_id(): void
    {
        $requestedUserID = 1;

        $response = $this->httpClient->request('GET', 'https://dummyjson.com/users/' . $requestedUserID);

        $decodedResponse = json_decode($response, true);

        $this->assertIsArray($decodedResponse);
        $this->assertArrayHasKey('id', $decodedResponse);
        $this->assertSame($requestedUserID, $decodedResponse['id']);
    }
}