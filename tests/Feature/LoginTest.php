<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LoginTest extends TestCase
{

    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(UserSeeder::class);
    }

    #[Test]
    public function an_existing_user_can_login(): void
    {
        $credentials = ['email' => 'example@example.com', 'password' => 'password'];
        $response = $this->post($this->apiBase . '/login' , $credentials);
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['token']]);
    }
    #[Test]
    public function an_non_existing_user_cannot_login(): void
    {
        $credentials = ['email' => 'example@noexisting.com', 'password' => 'nopassword'];
        $response = $this->post($this->apiBase . '/login' , $credentials);
        $response->assertStatus(401);
        $response->assertJsonFragment(['status' => 401, 'message' => 'Unauthorized']);
    }
    
    public function email_must_be_required(): void
    {
        $credentials = ['password' => 'nopassword'];
        $response = $this->post($this->apiBase . '/login' , $credentials);
        $response->assertStatus(401);
        $response->assertJsonStructure(['status' => 401]);
    }
    
    public function password_must_be_required(): void
    {
        $credentials = ['email' => 'example@example.com'];
        $response = $this->post($this->apiBase . '/login' , $credentials);
        $response->assertStatus(401);
        $response->assertJsonStructure(['status' => 401]);
    }
}
