<?php

namespace Tests\Feature\Settings;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileUpdateTest extends TestCase
{
    use RefreshDatabase;

    private Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();

        $this->admin = Admin::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'password' => bcrypt('password'),
        ]);
    }

    public function test_profile_page_is_displayed(): void
    {
        $this->actingAs($this->admin, 'admin')
            ->get(route('profile.edit'))
            ->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->patch(route('profile.update'), [
                'name' => 'Updated Name',
                'username' => 'updated-admin',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('profile.edit'));

        $this->admin->refresh();

        $this->assertSame('Updated Name', $this->admin->name);
        $this->assertSame('updated-admin', $this->admin->username);
    }

    public function test_username_must_be_unique(): void
    {
        Admin::create([
            'name' => 'Other Admin',
            'username' => 'other',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($this->admin, 'admin')
            ->patch(route('profile.update'), [
                'name' => 'Admin User',
                'username' => 'other',
            ])
            ->assertSessionHasErrors('username');

        $this->assertSame('admin', $this->admin->refresh()->username);
    }

    public function test_account_can_be_deleted(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->delete(route('profile.destroy'), ['password' => 'password']);

        $response->assertRedirect('/');

        $this->assertGuest('admin');
        $this->assertNull($this->admin->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $this->actingAs($this->admin, 'admin')
            ->from(route('profile.edit'))
            ->delete(route('profile.destroy'), ['password' => 'wrong-password'])
            ->assertSessionHasErrors('password');

        $this->assertNotNull($this->admin->fresh());
    }
}
