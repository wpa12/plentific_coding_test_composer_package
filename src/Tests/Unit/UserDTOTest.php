<?php

declare(strict_types=1);

namespace src\Tests\Unit;

use PHPUnit\Framework\TestCase;
use src\DTO\UserDTO;

class UserDTOTest extends TestCase
{
    /**
     * @var UserDTO
     */
    private UserDTO $userDTO;

    /**
     * setup the test environment
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->userDTO = new UserDTO([
            'id' => 1,
            'firstName' => 'Wayne',
            'lastName' => 'Anstey',
            'email' => 'w.anstey@example.com',
        ]);
    }

    /**
     * test that the user dto can be instantiated
     *
     * @return void
     */
    public function test_user_dto_can_be_instantiated(): void
    {
        $this->assertInstanceOf(UserDTO::class, $this->userDTO);
    }

    /**
     * test that the user dto can get id
     *
     * @return void
     */
    public function test_user_dto_can_get_id(): void
    {
        $this->assertEquals(1, $this->userDTO->getId());
    }

    /**
     * test that the user dto can return correct array data
     *
     * @return void
     */
    public function test_to_array_returns_correct_array_data(): void
    {
        $this->assertEquals([
            'id' => 1,
            'firstName' => 'Wayne',
            'lastName' => 'Anstey',
            'email' => 'w.anstey@example.com',
        ], $this->userDTO->toArray());
    }

    /**
     * test that the user dto can implement json serializable
     *
     * @return void
     */
    public function test_class_implements_json_serializable(): void
    {
        $this->assertInstanceOf(\JsonSerializable::class, $this->userDTO);
    }

    /**
     * test that the user dto can accept array of data
     *
     * @return void
     */
    public function test_dto_accepts_array_of_data(): void
    {
        $userDTO = new UserDTO([
            'id' => 1,
            'firstName' => 'Wayne',
            'lastName' => 'Anstey',
            'email' => 'w.anstey@example.com',
        ]);

        $this->assertInstanceOf(UserDTO::class, $userDTO);
        $this->assertEquals(1, $userDTO->getId());
        $this->assertEquals('Wayne', $userDTO->getFirstName());
        $this->assertEquals('Anstey', $userDTO->getLastName());
        $this->assertEquals('w.anstey@example.com', $userDTO->getEmail());
    }
}