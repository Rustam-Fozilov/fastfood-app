<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_can_create_user(): void
    {
        $response = $this->post('http://localhost:8000/api/users', [
            'name' => 'Sally',
            'email' => 'sally@app.com',
            'password' => bcrypt('password'),
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Sally',
            'email' => 'sally@app.com',
        ]);

        $response->assertStatus(200);
    }

    public function test_can_show_user()
    {
        $response = $this->get('http://localhost:8000/api/users');

        $response
            ->assertStatus(200)
            ->assertSee('Sally');
    }

    public function test_can_update_user()
    {
        $lastUserId = User::latest()->first()->id;

        $response = $this->put('http://localhost:8000/api/users/' . $lastUserId, [
            'name' => 'Sally2',
            'email' => 'sally2@app.com',
            'password' => bcrypt('password')
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Sally2',
            'email' => 'sally2@app.com',
        ]);

        $response->assertStatus(200);
    }

    public function test_can_delete_user()
    {
        $lastUserId = User::latest()->first()->id;

        $response = $this->delete('http://localhost:8000/api/users/' . $lastUserId);

        $this->assertDatabaseMissing('users', [
            'id' => $lastUserId,
            'name' => 'Sally2',
            'email' => 'sally2@app.com',
        ]);

        $response->assertStatus(200);
    }
}
