<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_screen_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    function test_users_can_authenticate_as_admin()
    {
        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'admin123456789'
        ]);

        $this->assertAuthenticated();
        $response->assertStatus(302);
        $response->assertRedirect('/productList');
    }

    function test_users_can_authenticate_as_user()
    {
        $response = $this->post('/login', [
            'email' => 'user@test.com',
            'password' => 'user123456789'
        ]);

        $this->assertAuthenticated();
        $response->assertStatus(302);
        $response->assertRedirect('/product');
    }

    function test_users_can_authenticate_with_invalid_password()
    {
        $response = $this->post('/login', [
            'email' => 'user@test.com',
            'password' => 'XXXXXXXXX'
        ]);

        $this->assertGuest();
    }

    function test_user_do_logout()
    {
        $response = $this->get('/logout');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
}
