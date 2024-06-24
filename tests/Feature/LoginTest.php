<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(UserSeeder::class);
    }

    /** @test */
    public function an_existing_user_can_login(): void
    {
        $this->withoutExceptionHandling();
        $credentials = ['email' => 'example@example.com', 'password' => 'password'];
        print($credentials['email'] . " " . $credentials['password'] . "\n");
        $response = $this->postJson("api/login", $credentials);
        print_r($response->getContent());
        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
    }

    /** @test */
    public function a_non_existing_user_cannot_login(): void
    {
        $credentials = ['email' => 'example@nonexisting.com', 'password' => 'password'];

        $response = $this->postJson("api/login", $credentials);

        $response->assertStatus(401);
        $response->assertJsonFragment(['status' => 401, 'message' => 'Invalid email or password']);
    }

    /** @test */
    public function email_must_be_required(): void
    {
        $credentials = ['password' => 'password'];

        $response = $this->postJson("api/login", $credentials);

        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'errors' => ['email']]);
        $response->assertJsonFragment(['errors' => ['email' => ['The email field is required.']]]);
    }

    /** @test */
    public function email_must_be_valid_email(): void
    {
        $credentials = ['email' => 'adasdasasd', 'password' => 'password'];

        $response = $this->postJson("api/login", $credentials);

        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'errors' => ['email']]);
        $response->assertJsonFragment(['errors' => ['email' => ['The email field must be a valid email address.']]]);
    }

    /** @test */
    public function email_must_be_a_string(): void
    {
        $credentials = ['email' => 123123123, 'password' => 'password'];

        $response = $this->postJson("api/login", $credentials);
        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'errors' => ['email']]);
    }

    /** @test */
    public function password_must_be_required(): void
    {
        $credentials = ['email' => 'example@nonexisting.com'];

        $response = $this->postJson('/api/login', $credentials);

        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'errors' => ['password']]);
    }

    /** @test */
    public function password_must_have_at_lease_8_characters(): void
    {
        $credentials = ['email' => 'example@nonexisting.com', 'password' => 'abcd'];

        $response = $this->postJson('/api/login', $credentials);

        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'errors' => ['password']]);
    }
}
