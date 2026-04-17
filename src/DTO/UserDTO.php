<?php

declare(strict_types=1);

namespace src\DTO;

use JsonSerializable;

class UserDTO implements JsonSerializable
{

    /**
     * construct the user dto
     *
     * @param array<string, mixed> $args
     */
    public function __construct(
        public array $args = []
    ) {}

    /**
     * get the id of the user
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->args['id'] ?? null;
    }

    /**
     * get the first name of the user
     *
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->args['firstName'] ?? null;
    }

    /**
     * get the last name of the user
     *
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->args['lastName'] ?? null;
    }

    /**
     * get the email of the user
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->args['email'] ?? null;
    }
    /**
     * convert to array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->args['id'] ?? null,
            'firstName' => $this->args['firstName'] ?? null,
            'lastName' => $this->args['lastName'] ?? null,
            'email' => $this->args['email'] ?? null,
        ];
    }

    /**
     * json serialized data
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
