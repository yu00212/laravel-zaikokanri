<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Stock;
use App\Models\User;

class AdminTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_admin_list_screen_can_be_rendered()
    {
        $response = $this->get('/admin/list');
        $response->assertStatus(302);
    }

    public function test_Can_Login(): void
    {
        $user = User::factory(User::class)->create([
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertRedirect('/admin/list');
        $this->assertAuthenticatedAs($user);
    }

    public function test_show_screen_can_be_rendered()
    {
        $response = $this->get('/admin/list/show/{id}');
        $response->assertStatus(302);
    }

    public function test_del_screen_can_be_rendered()
    {
        $response = $this->get('/admin/list/delCheck/{id}');
        $response->assertStatus(302);

        $response = $this->post('/admin/list/delDone/{id}');
        $response->assertStatus(302);
    }

    public function test_search_screen_can_be_rendered()
    {
        $response = $this->post('/admin/list/search');
        $response->assertStatus(302);
    }

    public function test_user_del_screen_can_be_rendered()
    {
        $response = $this->get('/admin/userList/delCheck/{id}');
        $response->assertStatus(302);

        $response = $this->post('/admin/userList/delDone/{id}');
        $response->assertStatus(302);
    }

    public function test_user_search_screen_can_be_rendered()
    {
        $response = $this->get('/admin/userList/search');
        $response->assertStatus(302);
    }

    public function testListFactoryTest()
    {
        //利用者アカウントでログインし利用者用の在庫一覧画面へ遷移
        $user = User::factory(User::class)->create([
            'id' => 9,
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        $response = $this->actingAs($user)->get('/list');

        //在庫を作成
        $stock = Stock::factory(Stock::class)->create();

        //利用者アカウントログアウト
        $this->post('logout');

        //管理者アカウントでログインし管理者用の在庫一覧画面へ遷移
        $adminUser = User::factory(User::class)->create([
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        $response = $this->actingAs($adminUser)->get('/admin/list');

        // /admin/listで在庫情報の2つのカラムが表示されているか確認
        $response->assertSee('在庫一覧');
        $response->assertSee($stock['name']);
        $response->assertSee($stock['user_id']);
    }

    public function testAdminInsertFactoryTest()
    {
        // ユーザー認証して在庫一覧画面に遷移
        $user = User::factory(User::class)->create([
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        $response = $this->actingAs($user)->get('/admin/list');

        //userロールのユーザ作成
        $users = User::factory(User::class)->create();

        $response = $this->actingAs($user)->get('/admin/userList');

        $response->assertSee('アカウント一覧');
        $response->assertSee($users['id']);
        $response->assertSee($users['name']);
        $response->assertSee($users['email']);
    }

    public function testShowFactoryTest()
    {
        //利用者アカウントでログインし利用者用の在庫一覧画面へ遷移
        $user = User::factory(User::class)->create([
            'id' => 3,
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        $response = $this->actingAs($user)->get('/list');

        //在庫を作成
        $stock = Stock::factory(Stock::class)->create([
            'shop' => 'セブン',
            'purchase_date' => '2021-04-12',
            'deadline' => '2021-06-12',
            'name' => 'サンプル',
            'price' => 200,
            'number' => 10,
        ]);

        //利用者アカウントログアウト
        $this->post('logout');

        //管理者アカウントでログインし管理者用の在庫一覧画面へ遷移
        $adminUser = User::factory(User::class)->create([
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        $response = $this->actingAs($adminUser)->get('/admin/list');

        // /listからログイン状態で詳細画面に遷移
        $response = $this->actingAs($adminUser)->get('/admin/list/show/'.$stock['id']);

        $response->assertSee('在庫詳細');
        $this->assertEquals('セブン', $stock['shop']);
        $this->assertEquals('2021-04-12', $stock['purchase_date']);
        $this->assertEquals('2021-06-12', $stock['deadline']);
        $this->assertEquals('サンプル', $stock['name']);
        $this->assertEquals(200, $stock['price']);
        $this->assertEquals(10, $stock['number']);
    }

    public function testDeleteFactoryTest()
    {
        //利用者アカウントでログインし利用者用の在庫一覧画面へ遷移
        $user = User::factory(User::class)->create([
            'id' => 7,
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        $response = $this->actingAs($user)->get('/list');
        $stock = Stock::factory(Stock::class)->create();
        $this->post('logout');

        $adminUser = User::factory(User::class)->create([
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        $response = $this->actingAs($adminUser)->get('/admin/list');
        $stock->delete();
        $this->assertDeleted($stock);
    }

    public function testSeachFactoryTest()
    {
        $user = User::factory(User::class)->create([
            'id' => 22,
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        $response = $this->actingAs($user)->get('/list');
        $stock = Stock::factory(Stock::class)->create([
            'shop' => 'セブン',
            'purchase_date' => '2021-04-12',
            'deadline' => '2021-06-12',
            'name' => 'サンプル',
            'price' => 200,
            'number' => 10,
        ]);
        $this->post('logout');

        $adminUser = User::factory(User::class)->create([
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        $response = $this->actingAs($adminUser)->get('/admin/list');

        //ログイン状態で検索結果画面に検索ワードをpostして遷移
        $response = $this->actingAs($adminUser)->post('/admin/list/search', [
            'search' => 'サンプル',
        ]);

        $response->assertSee('在庫検索');
        $response->assertSee('該当商品がありました');
        $this->assertEquals('2021-06-12', $stock['deadline']);
        $this->assertEquals('サンプル', $stock['name']);
        $this->assertEquals(10, $stock['number']);
    }

     //アカウント一覧画面レコード削除
    public function testAdminDeleteFactoryTest()
    {
         // ユーザー認証して画面遷移
        $user = User::factory(User::class)->create([
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        $response = $this->actingAs($user)->get('/admin/userList');

        $users = User::factory(User::class)->create();
        $users->delete();
        $this->assertDeleted($users);
    }

    //アカウント一覧画面レコード検索
    public function testAdminSeachFactoryTest()
    {
        $user = User::factory(User::class)->create([
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        $response = $this->actingAs($user)->get('/admin/userList');

        //userロールのユーザ作成
        $users = User::factory(User::class)->create();

        $response = $this->from('/admin/userList')->post('/admin/userList/search', [
            'search' => $users['name'],
        ]);

        $response->assertSee('アカウント検索');
        $response->assertSee($users['id']);
        $response->assertSee($users['name']);
        $response->assertSee($users['email']);
    }
}
