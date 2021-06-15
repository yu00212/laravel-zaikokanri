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

        $response = $this->post('/list/addCheck');
        $response->assertStatus(302);

        $response = $this->post('/list/addDone');
        $response->assertStatus(302);
    }

    public function test_show_screen_can_be_rendered()
    {
        $response = $this->get('/list/show/{id}');
        $response->assertStatus(302);
    }

    public function test_edit_screen_can_be_rendered()
    {
        $response = $this->get('/list/edit/{id}');
        $response->assertStatus(302);

        $response = $this->post('/list/editCheck/{id}');
        $response->assertStatus(302);

        $response = $this->post('/list/editDone/{id}');
        $response->assertStatus(302);
    }

    public function test_del_screen_can_be_rendered()
    {
        $response = $this->get('/list/delCheck/{id}');
        $response->assertStatus(302);

        $response = $this->post('/list/delDone/{id}');
        $response->assertStatus(302);
    }

    public function test_search_screen_can_be_rendered()
    {
        $response = $this->post('/list/search');
        $response->assertStatus(302);
    }

    //レコード追加・件数確認
    public function testInsertFactoryTest()
    {
        $stocks = Stock::factory(Stock::class)->count(3)->create();
        $count = count($stocks);
        $this->assertEquals(3, $count);
    }

    //レコード削除
    public function testDeleteFactoryTest()
    {
        $stock = Stock::factory(Stock::class)->create();
        $stock->delete();
        $this->assertDeleted($stock);
    }
}
