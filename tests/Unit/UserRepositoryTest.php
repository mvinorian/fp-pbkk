<?php

namespace Tests\Unit;

use App\Infrastrucutre\Repository\SqlUserRepository;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    /** @test */
    public function it_can_fetch_users_with_parameter_search()
    {
        $userRepository = new SqlUserRepository();
        $users = $userRepository->getAllWithSearch("Karin");
        
        $this->assertCount(1, $users);
        $this->assertIsArray($users);

        $this->assertEquals(23, $users[0]->getAge());
        $this->assertEquals('Karina Gislason', $users[0]->getName());
        
        $this->assertIsInt($users[0]->getAge());
        $this->assertIsString($users[0]->getName());
    }

}
