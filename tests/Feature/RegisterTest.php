<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterTest extends TestCase
{
    public function test_no_input(){
        $response = $this->postJson('api/register');
        $response
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors']);
    }
    public function test_invalid_input(){
        $data = [
            'email' => $this->faker->email,
            'name' => $this->faker->name,
            'password' => $this->faker->password(6),
        ];
        $response = $this->postJson('api/auth/register', $data);
        $response
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors']);
    }
    public function test_already_registered(){

        $password = $this->faker->password(8);
        $name = $this->faker->name;
        $email = $this->faker->email;
        $device_name = "iphone 12";

        $userData = [
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ];

        $user = User::create($userData);

        $formData = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ];

        $response = $this->postJson('api/register', $formData);
        $response
            ->assertStatus(409)
            ->assertJson(["error" => "You are already registered. Please login instead."]);
    }
    public function test_register_with_success(){

        $password = $this->faker->password(8);
        $name = $this->faker->name;
        $email = $this->faker->email;
        $device_name = "iphone 12";

        $userData = [
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'device_name' => $device_name,
        ];

        $response = $this->postJson('/api/register', $userData);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['email', 'name', 'token', 'created_at'])
            ->assertJson(['email' => $userData['email']]);
    }
}
