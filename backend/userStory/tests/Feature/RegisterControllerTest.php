<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory as Faker;

class RegisterControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_registration_screen_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_users_can_do_registration()
    {
        $faker = Faker::create();
        $safeEmail = $faker->freeEmail();
        $response = $this->post('/register', [
            'name' => 'Generate Testing',
            'email' => $safeEmail,
            'password' => 'admin123456789',
            'password_confirmation' => 'admin123456789'
        ]);

        $this->assertDatabaseHas('users', [
              'email' => $safeEmail,
         ]);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
}
