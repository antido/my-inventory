<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_register_and_is_redirected_to_the_dashboard(): void
    {
        $response = $this->post('/sign-up', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'jane@example.com']);
    }

    public function test_a_user_can_log_in(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_users_are_redirected_to_their_role_dashboard(): void
    {
        $user = User::factory()->create(['role' => UserRole::User->value]);

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertRedirect('/user/dashboard');
    }

    public function test_standard_users_cannot_access_the_admin_dashboard(): void
    {
        $user = User::factory()->create(['role' => UserRole::User->value]);

        $this->actingAs($user)
            ->get('/admin/dashboard')
            ->assertForbidden();
    }

    public function test_administrators_can_access_the_admin_dashboard(): void
    {
        $admin = User::factory()->create(['role' => UserRole::Admin->value]);

        $this->actingAs($admin)
            ->get('/dashboard')
            ->assertRedirect('/admin/dashboard');

        $this->actingAs($admin)
            ->get('/admin/dashboard')
            ->assertOk();
    }
}
