<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Stock;
use App\Models\User;

class StockTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_list_screen_can_be_rendered()
    {
        $response = $this->get('/list');
        $response->assertStatus(302);
    }

    public function test_Can_Login(): void
    {
        $user = User::factory(User::class)->create([
            'password' => bcrypt('password'),
        ]);
        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertRedirect('/list');
        $this->assertAuthenticatedAs($user);
    }

    public function test_add_screen_can_be_rendered()
    {
        $response = $this->get('/list/add');
        $response->assertStatus(302);
    }
}
