<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Support\Facades\Hash;
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
            'password' => 'password',
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
        $lastUser = User::latest()->first();

        $response = $this->put('http://localhost:8000/api/users/' . $lastUser->id, [
            'name' => 'Sally2',
            'email' => 'sally@app.com',
            'password' => 'password2',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Sally2',
            'email' => 'sally@app.com',
        ]);

        $response->assertStatus(200);
    }

    public function test_can_search_user()
    {
        $lastUser = User::latest()->first();

        $response = $this->post('http://localhost:8000/api/users/search', [
            'name' => $lastUser->name,
        ]);

        $response->assertStatus(200);
    }

    public function test_can_register_user()
    {
        $response = $this->post('http://localhost:8000/api/register', [
            'name' => 'Sally3',
            'email' => 'sall3y@app.com',
            'password' => 'password3',
        ]);

        $response->assertStatus(201);
    }

    public function test_can_delete_user()
    {
        $lastUser = User::latest()->first();

        $response = $this->delete('http://localhost:8000/api/users/' . $lastUser->id);
        $response2 = $this->delete('http://localhost:8000/api/users/' . $lastUser->id - 1);

        $this->assertDatabaseMissing('users', [
            'id' => $lastUser->id,
            'name' => $lastUser->name,
            'email' => $lastUser->email,
        ]);

        $response->assertStatus(200);
        $response2->assertStatus(200);
    }

    public function test_can_download_users()
    {
        $response = $this->get('http://localhost:8000/api/users-export');

        $response->assertStatus(200);
    }

    public function test_can_login_user()
    {
        $user = User::latest()->first();

        $response = $this->post('http://localhost:8000/api/login', [
            'email' => 'john@app.com',
            'password' => '1234',
        ]);

        $response->assertStatus(200);
    }
}
