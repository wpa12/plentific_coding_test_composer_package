<?php

declare(strict_types=1);

namespace src\Interfaces;

/**
 * Interface for classes that can fetch user/users.
 */
interface UserFetchableInterface {
    /**
     * get a user by id and return the user data as an array or a JSON string.
     *
     * @param integer $id
     * @param boolean $returnJson
     * @return array<string, mixed>|string
     */
    public function getUserById(int $id, bool $returnJson = true): array|string;

    /**
     * get users and return the users data as an array or a JSON string.
     *
     * @param integer $limit
     * @param integer $skip
     * @param array<string, mixed> $select
     * @param boolean $returnJson
     * @return array<string, mixed>|string
     */
    public function getUsers(int $limit = 30, int $skip = 0, array $select = [], bool $returnJson = false): array|string;
}