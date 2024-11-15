<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected UserRepository $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = new UserRepository(new User());
    }

    public function test_find_returns_user_by_id()
    {
        $user = User::factory()->create();

        $foundUser = $this->userRepository->find($user->id);

        $this->assertInstanceOf(User::class, $foundUser);
        $this->assertEquals($user->id, $foundUser->id);
    }

    public function test_update_updates_existing_user()
    {
        $user = User::factory()->create();

        $updatedData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ];

        $updatedUser = $this->userRepository->update($user->id, $updatedData);

        $this->assertEquals($updatedData['name'], $updatedUser->name);
        $this->assertEquals($updatedData['email'], $updatedUser->email);
    }

    public function test_update_throws_exception_for_non_existent_user()
    {
        $nonExistentUserId = 9999; 

        $this->expectException(\Exception::class);  

        $this->userRepository->update($nonExistentUserId, ['name' => 'Updated Name']);
    }

    public function test_destroy_deletes_existing_user()
    {
        $user = User::factory()->create();

        $this->userRepository->destroy($user->id);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_destroy_throws_exception_for_non_existent_user()
    {
        $nonExistentUserId = 9999; 

        $this->expectException(\Exception::class);  

        $this->userRepository->destroy($nonExistentUserId);
    }
}
