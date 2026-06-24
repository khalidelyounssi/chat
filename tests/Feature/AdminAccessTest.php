<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_pages(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertUnauthorized();
    }

    public function test_non_admin_user_cannot_access_admin_pages(): void
    {
        $this->actingAs(User::factory()->create([
            'email' => 'member@example.com',
        ]));

        $this->get(route('admin.dashboard'))
            ->assertForbidden();
    }
}
