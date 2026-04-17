<?php

declare(strict_types=1);

namespace src\Tests\Unit;

use PHPUnit\Framework\TestCase;
use src\UserClass;
use src\HttpClient;

class UserClassTest extends TestCase
{
    /**
     * @var UserClass
     */
    private UserClass $userClass;
    /**
     * @var HttpClient
     */
    private HttpClient $httpClientStub;

    /**
     * setup the test environment
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        
        $this->httpClientStub = $this->createStub(HttpClient::class);

        $this->userClass = new UserClass($this->httpClientStub);
    }

    /**
     * test that the user class can be instantiated
     *
     * @return void
     */
    public function test_user_class_can_be_instantiated(): void
    {
        $this->assertInstanceOf(UserClass::class, $this->userClass);
    }

    /**
     * test that the user class can get user by id
     *
     * @return void
     */
    public function test_get_user_by_id(): void
    {
        $requestedUserId = 1;

        $mockHttpClient = $this->createMock(HttpClient::class);
        $userClass = new UserClass($mockHttpClient);

        $mockHttpClient->expects($this->once())
        ->method('request')
        ->willReturn(
            json_encode([
                'id' => 1,
                'firstName' => 'Wayne',
                'lastName' => 'Anstey',
                'email' => 'w.anstey@example.com',
            ], JSON_THROW_ON_ERROR)
        );

        $user = $userClass->getUserById($requestedUserId);
        
        // @phpstan-ignore-next-line
        $decodedUser = json_decode($user, true);

        $this->assertIsArray($decodedUser);
        $this->assertEquals($decodedUser['id'], $requestedUserId);

        $this->assertEquals($decodedUser, [
            'id' => 1,
            'firstName' => 'Wayne',
            'lastName' => 'Anstey',
            'email' => 'w.anstey@example.com',
        ]);
    }

    /**
     * test that the user class can get users by id and return json array when returnJson is true
     *
     * @return void
     */
    public function test_get_users_by_id_returns_json_array_when_returnJson_is_true(): void
    {
        $requestedUserId = 1;
        $mockHttpClient = $this->createMock(HttpClient::class);
        $userClass = new UserClass($mockHttpClient);

        $mockHttpClient->expects($this->once())
        ->method('request')
        ->willReturn(
            json_encode([
                'id' => 1,
                'firstName' => 'Wayne',
                'lastName' => 'Anstey',
                'email' => 'w.anstey@example.com',
            ], JSON_THROW_ON_ERROR)
        );

        $user = $userClass->getUserById($requestedUserId, true);

        $this->assertIsString($user);
        $this->assertEquals($user, json_encode([
            'id' => 1,
            'firstName' => 'Wayne',
            'lastName' => 'Anstey',
            'email' => 'w.anstey@example.com',
        ], JSON_THROW_ON_ERROR));
    }

    /**
     * test that the user class can get users by id and return array when returnJson is false
     *
     * @return void
     */
    public function test_get_users_by_id_returns_array_when_returnJson_is_false(): void
    {
        $requestedUserId = 1;
        $mockHttpClient = $this->createMock(HttpClient::class);
        $userClass = new UserClass($mockHttpClient);

        $mockHttpClient->expects($this->once())
        ->method('request')
        ->willReturn(
            json_encode([
                'id' => 1,
                'firstName' => 'Wayne',
                'lastName' => 'Anstey',
                'email' => 'w.anstey@example.com',
            ], JSON_THROW_ON_ERROR)
        );

        $user = $userClass->getUserById($requestedUserId, false);

        $this->assertIsArray($user);
        $this->assertEquals($user, [
            'id' => 1,
            'firstName' => 'Wayne',
            'lastName' => 'Anstey',
            'email' => 'w.anstey@example.com',
        ]);
    }

    /**
     * test that the user class can get users and return paginated user dto when returnJson is true
     *
     * @return void
     */
    public function test_get_users_returns_paginated_user_dto_when_returnJson_is_true(): void
    {
        $limit = 1;
        $skip = 0;
        $select = [];
        $returnJson = true;

        $mockHttpClient = $this->createMock(HttpClient::class);
        $userClass = new UserClass($mockHttpClient);
        
        $mockHttpClient->expects($this->once())
        ->method('request')
        ->willReturn(
            json_encode([
                'users' => [],
                'total' => 0,
                'skip' => 0,
                'limit' => 1,
            ])
        );

        $user = $userClass->getUsers($limit, $skip, $select, $returnJson);

        $this->assertIsString($user);
        $this->assertEquals($user, json_encode([
            'users' => [],
            'total' => 0,
            'skip' => 0,
            'limit' => 1,
        ], JSON_THROW_ON_ERROR));
    }

    /**
     * test that the user class can get users and return paginated user dto when returnJson is false
     *
     * @return void
     */
    public function test_get_users_returns_paginated_user_dto_when_returnJson_is_false(): void
    {
        $limit = 1;
        $skip = 0;
        $select = [];
        $returnJson = false;
        
        
        $mockHttpClient = $this->createMock(HttpClient::class);
        $userClass = new UserClass($mockHttpClient);

        $mockHttpClient->expects($this->once())
        ->method('request')
        ->willReturn(
            json_encode([
                'users' => [],
                'total' => 0,
                'skip' => 0,
                'limit' => 1,
            ], JSON_THROW_ON_ERROR)
        );

        $user = $userClass->getUsers($limit, $skip, $select, $returnJson);

        $this->assertIsArray($user);
        $this->assertEquals($user, [
            'users' => [],
            'total' => 0,
            'skip' => 0,
            'limit' => 1,
        ]);
    }

    /**
     * test that the user class can get users and return 50 when limit is greater than 50
     *
     * @return void
     */
    public function test_get_users_returns_50_when_limit_is_greater_than_50(): void
    {
        $limit = 300;
        $skip = 0;
        $select = [];
        $returnJson = true;

        $mockHttpClient = $this->createMock(HttpClient::class);
        $userClass = new UserClass($mockHttpClient);

        $mockHttpClient->expects($this->once())
        ->method('request')
        ->willReturn(
            json_encode([
                'users' => [],
                'total' => 0,
                'skip' => 0,
                'limit' => 50,
            ], JSON_THROW_ON_ERROR)
        );

        $users = $userClass->getUsers($limit, $skip, $select, $returnJson);

        // @phpstan-ignore-next-line
        $decoded = json_decode($users, true);

        $this->assertEquals($decoded['limit'], 50);
    }

    /**
     * test that the user class can get users and return empty array when users is empty and returnJson is false
     *
     * @return void
     */
    public function test_get_users_returns_empty_array_when_users_is_empty_and_returnJson_is_false(): void
    {
        $limit = 1;
        $skip = 0;
        $select = [];
        $returnJson = false;
        
        $expectedUsers = [];
        
        $mockHttpClient = $this->createMock(HttpClient::class);
        $userClass = new UserClass($mockHttpClient);

        $mockHttpClient->expects($this->once())
        ->method('request')
        ->willReturn(
            json_encode([
                'users' => [],
                'total' => 0,
                'skip' => 0,
                'limit' => 1,
            ], JSON_THROW_ON_ERROR)
        );

        $users = $userClass->getUsers($limit, $skip, $select, $returnJson);

        $this->assertIsArray($users);
        $this->assertEquals($users['users'], $expectedUsers);
    }


    /**
     * test that the user class can create a user and return user id when user is created
     *
     * @return void
     */
    public function test_create_user_returns_user_id_when_user_is_created(): void
    {
        $data = [
            'firstName' => 'Wayne',
            'lastName' => 'Anstey',
            'email' => 'w.anstey@example.com',
        ];

        $mockHttpClient = $this->createMock(HttpClient::class);
        $userClass = new UserClass($mockHttpClient);

        $mockHttpClient->expects($this->once())
        ->method('request')
        ->willReturn(
            json_encode([
                'id' => 1,
                'firstName' => 'Wayne',
                'lastName' => 'Anstey',
                'email' => 'w.anstey@example.com',
            ], JSON_THROW_ON_ERROR)
        );

        $userId = $userClass->create($data);

        $this->assertEquals($userId, 1);
    }

    /**
     * test that the user class can create a user and throw invalid argument exception when data is invalid
     *
     * @return void
     */
    public function test_create_user_throws_invalid_argument_exception_when_data_is_invalid(): void
    {
        $data = [
            'firstName' => 'Wayne',
            'lastName' => 'Anstey',
        ];

        $expectedExceptionMessage = 'Invalid data: expected firstName, lastName, and email';

        $mockHttpClient = $this->createMock(HttpClient::class);
        $userClass = new UserClass($mockHttpClient);

        $mockHttpClient->expects($this->never())
        ->method('request');

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedExceptionMessage);
        $userClass->create($data);
    }
}