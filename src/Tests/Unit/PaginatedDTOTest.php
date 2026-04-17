<?php

declare(strict_types=1);

namespace src\Tests\Unit;

use PHPUnit\Framework\TestCase;
use src\DTO\PaginatedUserDTO;
use src\DTO\UserDTO;

class PaginatedDTOTest extends TestCase
{
    /**
     * @var PaginatedUserDTO
     */
    private PaginatedUserDTO $paginatedUserDTO;
    /**
     * @var array<string, mixed>
     */
    private array $users = [];
    /**
     * @var int
     */
    private int $total = 0;
    /**
     * @var int
     */
    private int $skip = 0;
    /**
     * @var int
     */
    private int $limit = 30;


    /**
     * setup the test environment
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->paginatedUserDTO = new PaginatedUserDTO(
            $this->users,
            $this->total,
            $this->skip,
            $this->limit
        );
    }

    /**
     * test that the paginated user dto can be instantiated
     *
     * @return void
     */
    public function test_paginated_user_dto_can_be_instantiated(): void
    {
        $this->assertInstanceOf(PaginatedUserDTO::class, $this->paginatedUserDTO);
    }

    /**
     * test that the paginated user dto can get users
     *
     * @return void
     */
    public function test_paginated_user_dto_can_get_users(): void
    {
        $this->assertEquals($this->users, $this->paginatedUserDTO->users);
    }

    /**
     * test that the paginated user dto can get total
     *
     * @return void
     */
    public function test_paginated_user_dto_can_get_total(): void
    {
        $this->assertEquals($this->total, $this->paginatedUserDTO->total);
    }

    /**
     * test that the paginated user dto can get skip
     *
     * @return void
     */
    public function test_paginated_user_dto_can_get_skip(): void
    {
        $this->assertEquals($this->skip, $this->paginatedUserDTO->skip);
    }

    /**
     * test that the paginated user dto can get limit
     *
     * @return void
     */
    public function test_paginated_user_dto_can_get_limit(): void
    {
        $this->assertEquals($this->limit, $this->paginatedUserDTO->limit);
    }

    /**
     * test that the paginated user dto can get array data
     *
     * @return void
     */
    public function test_paginated_user_dto_can_get_array_data(): void
    {
        $this->assertEquals([
            'users' => $this->users,
            'total' => $this->total,
            'skip' => $this->skip,
            'limit' => $this->limit,
        ], $this->paginatedUserDTO->toArray());
    }

    /**
     * test that the paginated user dto can get json serializable
     *
     * @return void
     */
    public function test_paginated_user_dto_can_get_json_serializable(): void
    {
        $this->assertInstanceOf(\JsonSerializable::class, $this->paginatedUserDTO);
    }

    /**
     * test that the paginated user dto can get json serialize
     *
     * @return void
     */
    public function test_paginated_user_dto_can_get_json_serialize(): void
    {
        $this->assertEquals($this->paginatedUserDTO->toArray(), $this->paginatedUserDTO->jsonSerialize());
    }

    /**
     * test that the paginated user dto can accept array of user dtos
     *
     * @return void
     */
    public function test_paginated_user_dto_can_accept_array_of_user_dtos(): void
    {
        $users = [
            new UserDTO([
                'id' => 1,
                'firstName' => 'Wayne',
                'lastName' => 'Anstey',
                'email' => 'w.anstey@example.com',
            ]),
            new UserDTO([
                'id' => 2,
                'firstName' => 'John',
                'lastName' => 'Doe',
                'email' => 'j.doe@example.com',
            ]),
        ];

        $paginatedUserDTO = new PaginatedUserDTO($users, $this->total, $this->skip, $this->limit);
        $this->assertEquals($users, $paginatedUserDTO->users);
        $this->assertEquals($this->total, $paginatedUserDTO->total);
        $this->assertEquals($this->skip, $paginatedUserDTO->skip);
        $this->assertEquals($this->limit, $paginatedUserDTO->limit);
    }
}