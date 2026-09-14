<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProductManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_admin_can_manage_products(): void
    {
        $admin = User::factory()->create(['role' => UserRole::Admin->value]);

        $this->actingAs($admin)->post('/admin/products', [
            'name' => 'Wireless Scanner',
            'sku' => 'SCAN-001',
            'description' => 'Handheld barcode scanner',
            'quantity' => 12,
            'price' => '1499.50',
        ])->assertRedirect('/admin/products');

        $product = Product::where('sku', 'SCAN-001')->firstOrFail();

        $this->actingAs($admin)->put("/admin/products/{$product->id}", [
            'name' => 'Wireless Barcode Scanner',
            'sku' => 'SCAN-001',
            'description' => 'Updated description',
            'quantity' => 10,
            'price' => '1399.50',
        ])->assertRedirect('/admin/products');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Wireless Barcode Scanner',
            'quantity' => 10,
        ]);

        $this->actingAs($admin)->delete("/admin/products/{$product->id}")
            ->assertRedirect('/admin/products');

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_an_admin_can_search_products(): void
    {
        $admin = User::factory()->create(['role' => UserRole::Admin->value]);
        Product::create(['name' => 'Blue Pen', 'sku' => 'PEN-001', 'quantity' => 20, 'price' => 15]);
        Product::create(['name' => 'Red Marker', 'sku' => 'MARK-001', 'description' => 'Permanent ink', 'quantity' => 5, 'price' => 45]);

        $this->actingAs($admin)->get('/admin/products?search=permanent')
            ->assertOk()
            ->assertSee('Red Marker')
            ->assertDontSee('Blue Pen');
    }

    public function test_a_standard_user_cannot_manage_products(): void
    {
        $user = User::factory()->create(['role' => UserRole::User->value]);

        $this->actingAs($user)->get('/admin/products')->assertForbidden();
    }
}
