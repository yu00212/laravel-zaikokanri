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

    //レコード更新
    public function testUpdateFactoryTest()
    {
        $stock = Stock::factory(Stock::class)->create();

        $stock->update([
            'shop' => 'サンプル',
            'purchase_date' => '2021-04-12',
            'deadline' => '2021-06-12',
            'name' => 'サンプル',
            'price' => 200,
            'number' => 10
        ]);

        $this->assertEquals('サンプル', $stock['shop']);
        $this->assertEquals('2021-04-12', $stock['purchase_date']);
        $this->assertEquals('2021-06-12', $stock['deadline']);
        $this->assertEquals('サンプル', $stock['name']);
        $this->assertEquals(200, $stock['price']);
        $this->assertEquals(10, $stock['number']);
    }

    public function testListFactoryTest()
    {
        // 在庫を2つ作成
        $first = Stock::factory(Stock::class)->create();
        $second = Stock::factory(Stock::class)->create();

        // ユーザー認証して画面遷移
        $user = User::factory(User::class)->create([
            'password' => bcrypt('password'),
        ]);
        $response = $this->actingAs($user)->get('/list');

        $response->assertSee('在庫一覧');
        $response->assertSee($user->name);
        $response->assertSee($user->email);

        // listで在庫情報の3つのカラムが表示されているか確認
        $response->assertSee($first->deadline->format('Y-m-d'));
        $response->assertSee($first->name);
        $response->assertSee($first->number);
        $response->assertSee($second->deadline->format('Y-m-d'));
        $response->assertSee($second->name);
        $response->assertSee($second->number);
    }

    public function testShowFactoryTest()
    {
        $stock = Stock::factory(Stock::class)->create();

        // ユーザー認証して詳細画面に遷移
        $user = User::factory(User::class)->create([
            'password' => bcrypt('password'),
        ]);
        $response = $this->actingAs($user)->get('/list/show/'.$stock->id);

        $response->assertSee('在庫詳細');
        $response->assertSee($stock->shop);
        $response->assertSee($stock->purchase_date->format('Y-m-d'));
        $response->assertSee($stock->deadline->format('Y-m-d'));
        $response->assertSee($stock->name);
        $response->assertSee($stock->price);
        $response->assertSee($stock->number);
    }
}
