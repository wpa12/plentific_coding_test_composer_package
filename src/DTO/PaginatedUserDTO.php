<?php
declare(strict_types=1);

namespace src\DTO;

use JsonSerializable;

/**
 * Created this DTO to handle accept and array of user DTOs for pagination purposes.
 */
class PaginatedUserDTO implements JsonSerializable
{
    /**
     * @var array<UserDTO>
     */
    public array $users;
    /**
     * @var int
     */
    public int $total;
    /**
     * @var int
     */
    public int $skip;
    /**
     * @var int
     */
    public int $limit;
 
    /**
     * construct the paginated user dto
     *
     * @param array<UserDTO> $users
     * @param int $total
     * @param int $skip
     * @param int $limit
     */
    public function __construct(array $users, int $total, int $skip, int $limit)
    {
        $this->users = $users;
        $this->total = $total;
        $this->skip = $skip;
        $this->limit = $limit;
    }

    /**
     * convert the paginated user dto to an array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'users' => array_map(fn($user) => $user->toArray(), $this->users),
            'total' => $this->total,
            'skip' => $this->skip,
            'limit' => $this->limit,
        ];
    }

    /**
     * json serialize the paginated user dto
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
