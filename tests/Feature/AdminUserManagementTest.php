<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use App\Models\Role;
use App\Models\Privilege;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_admin_can_create_a_user(): void
    {
        $admin = User::factory()->create(['role' => UserRole::Admin->value]);

        $response = $this->actingAs($admin)->post('/admin/users', [
            'name' => 'Managed User',
            'email' => 'managed@example.com',
            'role' => UserRole::User->value,
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'is_active' => true,
        ]);

        $response->assertRedirect('/admin/users');
        $this->assertDatabaseHas('users', [
            'email' => 'managed@example.com',
            'role' => UserRole::User->value,
            'is_active' => 1,
        ]);
    }

    public function test_a_standard_user_cannot_manage_users(): void
    {
        $user = User::factory()->create(['role' => UserRole::User->value]);

        $this->actingAs($user)
            ->get('/admin/users')
            ->assertForbidden();
    }

    public function test_an_admin_can_create_a_role_with_privileges_and_assign_it_to_a_user(): void
    {
        $admin = User::factory()->create(['role' => UserRole::Admin->value]);
        $privilege = Privilege::create(['name' => 'view reports']);

        $this->actingAs($admin)->post('/admin/roles', [
            'name' => 'Reporter',
            'privilege_ids' => [$privilege->id],
        ])->assertRedirect('/admin/roles');

        $role = Role::where('name', 'Reporter')->firstOrFail();

        $this->actingAs($admin)->post('/admin/users', [
            'name' => 'Report User',
            'email' => 'report@example.com',
            'role' => UserRole::User->value,
            'role_ids' => [$role->id],
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'is_active' => true,
        ])->assertRedirect('/admin/users');

        $user = User::where('email', 'report@example.com')->firstOrFail();
        $this->assertTrue($user->hasPrivilege('view reports'));
        $this->assertDatabaseHas('role_user', ['role_id' => $role->id, 'user_id' => $user->id]);
    }
}
