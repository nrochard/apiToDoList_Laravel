<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginTest extends TestCase
{
    //Test pour checker si l'utilisateur met des infos
    public function test_no_input(){
        $response = $this->postJson('api/auth/login');
        $response
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors']);
    }
   
    public function test_invalid_input(){
        $data = [
            'email' => $this->faker->name,
            'passwordd' => $this->faker->password(6),
            'device_name' => 'iphone 12'
        ];
        $response = $this->postJson('api/login', $data);
        $response
            ->assertStatus(422)
            ->assertJsonStructure(['message', 'errors']);
    }
     //Test pour checker si l'utilisateur a mis des infos qui existent en db
    public function test_invalid_credentials(){
        $data = [
            'email' => $this->faker->email,
            'password' => $this->faker->password(8),
            'device_name' => "iphone 12"
        ];
        $response = $this->postJson('api/login', $data);
        $response
            ->assertStatus(401)
            ->assertJsonStructure(['error']);
    }
     //Test pour checker si l'utilisateur est connecté 
    public function test_login_with_success(){

        $password = $this->faker->password(8);

        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => Hash::make($password) ,
        ];

        $user = User::create($userData);

        $formData = [
            'device_name' => "iphone 12",
            'email' => $user->email,
            'password' =>  $password,
        ];

        $response = $this->postJson('/api/login', $formData);

        $this->assertDatabaseHas('users', $userData);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['email', 'name', 'token'])
            ->assertJson(['email' => $user->email]);
    }

}
