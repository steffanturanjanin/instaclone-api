<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_signup()
    {
        $response = $this->postJson('/api/auth/signup', [
            'username' => 'test.user',
            'email' => 'test@example.com',
            'password' => '123456',
            'password_confirmation' => '123456',
        ]);

        $response->assertStatus(201);
        $response->assertSee('test@example.com');

        $this->assertDatabaseHas('users', [
            'username' => 'test.user',
            'email' => 'test@example.com',
        ]);
    }

    /** @test */
    public function user_needs_to_confirm_password_in_order_to_signup()
    {
        $response = $this->postJson('/api/auth/signup', [
            'username' => 'test.user',
            'email' => 'test@example.com',
            'password' => '123456',
            'password_confirmation' => '654321',
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors('password');

        $this->assertDatabaseMissing('users', [
            'email' => 'test@example.com'
        ]);
    }

    /** @test */
    public function user_cannot_signup_with_email_that_is_already_taken()
    {
        $existingUser = new User([
            'username' => 'existing.user',
            'email' => 'existing@email.com',
            'password' => '123456'
        ]);
        $existingUser->save();

        $response = $this->postJson('/api/auth/signup', [
            'username' => 'test.user',
            'email' => 'existing@email.com',
            'password' => '123456',
            'password_confirmation' => '123456',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }
}
