<?php

declare(strict_types=1);

namespace src\Interfaces;

/**
 * Interface for classes that can create a user.
 */
interface CreateableInterface {
    /**
     * create a new user and return the user id as an integer.
     *
     * @param array<string, mixed> $data
     * @return integer|null
     */
    public function create(array $data = []): ?int;
}
