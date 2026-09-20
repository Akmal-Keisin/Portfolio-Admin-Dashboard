<?php

namespace Tests\Feature\Auth;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Admin::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'password' => bcrypt('password'),
        ]);
    }

    public function test_login_screen_can_be_rendered()
    {
        $this->get(route('login'))->assertOk();
    }

    public function test_admins_can_authenticate_using_the_login_screen()
    {
        $response = $this->post(route('post-login'), [
            'username' => $this->admin->username,
            'password' => 'password',
        ]);

        $this->assertAuthenticated('admin');
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_admins_can_not_authenticate_with_invalid_password()
    {
        $this->post(route('post-login'), [
            'username' => $this->admin->username,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest('admin');
    }

    public function test_admins_can_remember_their_login()
    {
        $this->post(route('post-login'), [
            'username' => $this->admin->username,
            'password' => 'password',
            'remember' => true,
        ]);

        $this->assertNotNull($this->admin->fresh()->getRememberToken());
    }

    public function test_admins_can_logout()
    {
        $response = $this->actingAs($this->admin, 'admin')->post(route('logout'));

        $this->assertGuest('admin');
        $response->assertRedirect(route('home'));
    }

    public function test_login_is_rate_limited()
    {
        for ($attempt = 0; $attempt < 6; $attempt++) {
            $this->post(route('post-login'), [
                'username' => $this->admin->username,
                'password' => 'wrong-password',
            ]);
        }

        $this->post(route('post-login'), [
            'username' => $this->admin->username,
            'password' => 'wrong-password',
        ])->assertTooManyRequests();
    }
}
