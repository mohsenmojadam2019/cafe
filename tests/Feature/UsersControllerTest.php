<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_paginated_list_of_users()
    {
        User::factory(10)->create();

        $response = $this->get('/api/users');

        $response->assertStatus(200);

        $response->assertJsonStructure(['data']);
    }

    public function test_can_create_a_user()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        $response = $this->post('/api/users', $userData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_can_show_a_user()
    {
        $user = User::factory()->create();

        $response = $this->get("/api/users/{$user->id}");

        $response->assertStatus(200);

        $response->assertJsonStructure(['data']);
    }

    public function test_can_update_a_user()
    {
        $user = User::factory()->create();

        $updatedData = [
            'name' => 'Updated User',
            'email' => 'updated@example.com',
            'password' => 'newpassword123',
        ];

        $response = $this->put("/api/users/{$user->id}", $updatedData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', ['email' => 'updated@example.com']);
    }

    public function test_can_delete_a_user()
    {
        $user = User::factory()->create();

        $response = $this->delete("/api/users/{$user->id}");

        $response->assertStatus(200);

        $this->assertDeleted($user);
    }
}

