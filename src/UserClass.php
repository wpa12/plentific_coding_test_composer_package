<?php

declare(strict_types=1);

namespace src;

use src\DTO\UserDTO;
use src\HttpClient;
use src\Interfaces\CreateableInterface;
use src\DTO\PaginatedUserDTO;
use src\Interfaces\UserFetchableInterface;

class UserClass implements CreateableInterface, UserFetchableInterface
{
    /**
     * construct the user class
     *
     * @param HttpClient $httpClient
     * @param string $baseUrl
     * @param string $endpoint
     */
    public function __construct(
        private HttpClient $httpClient,
        private string $baseUrl = 'https://dummyjson.com/',
        private string $endpoint = 'users'
    ) {}

    /**
     * get the user by id and return the user data as an array or a JSON string.
     *
     * @param integer $id
     * @param boolean $returnJson
     * @return array<string, mixed>|string
     */
    public function getUserById(int $id, bool $returnJson = true): array|string
    {
        $response = $this->httpClient->request('GET', $this->baseUrl . $this->endpoint . '/' . $id);

        $decodedResponse = json_decode($response, true);
        
        $data = new UserDTO($decodedResponse);

        if(! $returnJson) {
            return $data->toArray();
        }

        return json_encode($data, JSON_THROW_ON_ERROR);
    }

    /**
     * get the users and return the users data as an array
     *
     * @param integer $limit
     * @param integer $skip
     * @param array<string, mixed> $select
     * @param boolean $returnJson
     * @return array<string, mixed>|string
     */
    public function getUsers(
        int $limit = 30,
        int $skip = 0,
        array $select = [],
        bool $returnJson = false
    ): array|string {

        if($limit > 50) {
            $limit = 50;
        }

        $queryParams = [
            'limit' => $limit,
            'skip' => $skip,
            'select' => implode(',', $select),
        ];

        $response = $this->httpClient->request(
            'GET',
            $this->baseUrl . $this->endpoint . '?' . http_build_query($queryParams)
        );

        $decoded = json_decode($response, true);

        $users = [];
        if (isset($decoded['users']) && is_array($decoded['users'])) {
            $users = array_map(fn(array $userData) => new UserDTO($userData), $decoded['users']);
        }

        $paginated = new PaginatedUserDTO(
            $users,
            $decoded['total'] ?? 0,
            $decoded['skip'] ?? $skip,
            $decoded['limit'] ?? $limit
        );

        if (! $returnJson) {
            return $paginated->toArray();
        }

        return json_encode($paginated, JSON_THROW_ON_ERROR);
    }

    /**
     * create a new user and return the user id as an integer.
     *
     * @param array<string, mixed> $data
     * @return integer|null
     */
    public function create(array $data = []): ?int
    {
        $slug = '/add';

        if(! isset($data['firstName']) || ! isset($data['lastName']) || ! isset($data['email'])) {
            throw new \InvalidArgumentException('Invalid data: expected firstName, lastName, and email');
        }

        $response = $this->httpClient->request('POST', $this->baseUrl . $this->endpoint . $slug, [
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'email' => $data['email'],
        ]);

        $data = (new UserDTO(json_decode($response, true)));

        return $data->getId();
    }
}
