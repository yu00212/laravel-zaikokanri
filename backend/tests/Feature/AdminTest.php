<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    public function testAdminListScreenCanBeRendered()
    {
        $response = $this->get('/admin/list');
        $response->assertStatus(302);
    }

    public function testCanLogin(): void
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

    public function testShowScreenCanBeRendered()
    {
        $response = $this->get('/admin/list/show/{id}');
        $response->assertStatus(302);
    }

    public function testDelScreenCanBeRendered()
    {
        $response = $this->get('/admin/list/delCheck/{id}');
        $response->assertStatus(302);

        $response = $this->post('/admin/list/delDone/{id}');
        $response->assertStatus(302);
    }

    public function testSearchScreenCanBeRendered()
    {
        $response = $this->post('/admin/list/search');
        $response->assertStatus(302);
    }

    public function testUserDelScreenCanBeRendered()
    {
        $response = $this->get('/admin/userList/delCheck/{id}');
        $response->assertStatus(302);

        $response = $this->post('/admin/userList/delDone/{id}');
        $response->assertStatus(302);
    }

    public function testUserSearchScreenCanBeRendered()
    {
        $response = $this->get('/admin/userList/search');
        $response->assertStatus(302);
    }

    //在庫レコード一覧表示
    public function testListFactoryTest()
    {
        //利用者アカウントでログインし利用者用の在庫一覧画面へ遷移
        $user = User::factory(User::class)->create([
            'id' => 9,
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        $response = $this->actingAs($user)->get('/list');

        //在庫作成
        $stock = Stock::factory(Stock::class)->create();

        //利用者アカウントログアウト
        $this->post('logout');

        //管理者アカウントでログインし管理者用の在庫一覧画面へ遷移
        $adminUser = User::factory(User::class)->create([
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        $response = $this->actingAs($adminUser)->get('/admin/list');

        //タイトル表示確認
        $response->assertSee('在庫一覧');
        //在庫情報表示確認
        $response->assertSee($stock['name']);
        $response->assertSee($stock['user_id']);
    }

    //アカウント一覧表示
    public function testAdminInsertFactoryTest()
    {
        // ユーザー認証して在庫一覧画面に遷移
        $user = User::factory(User::class)->create([
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        $response = $this->actingAs($user)->get('/admin/list');

        //userロールのユーザを作成してアカウント一覧画面に遷移
        $users = User::factory(User::class)->create();
        $response = $this->actingAs($user)->get('/admin/userList');

        //タイトル表示確認
        $response->assertSee('アカウント一覧');
        //アカウント情報表示確認
        $response->assertSee($users['id']);
        $response->assertSee($users['name']);
        $response->assertSee($users['email']);
    }

    //在庫レコード詳細表示
    public function testShowFactoryTest()
    {
        //利用者アカウントでログインし利用者用の在庫一覧画面へ遷移
        $user = User::factory(User::class)->create([
            'id' => 3,
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        $response = $this->actingAs($user)->get('/list');

        //フェイクディスクの作成
        Storage::fake('s3');

        //UploadedFileクラス用意
        $file = UploadedFile::fake()->image('stock.jpg');

        //S3にアップロードする処理
        $file->storeAs('', 'dummy.jpg', ['disk' => 's3']);

        //在庫作成
        $stock = Stock::factory(Stock::class)->create([
            'shop' => 'サンプル',
            'purchase_date' => '2021-04-12',
            'deadline' => '2021-06-12',
            'name' => 'サンプル',
            'price' => 200,
            'number' => 10,
            'image' => $file,
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
        $response = $this->actingAs($adminUser)->get('/admin/list/show/' . $stock['id']);

        //S3にアップロードされたか確認。
        Storage::disk('s3')->assertExists('dummy.jpg');
        //タイトル表示確認
        $response->assertSee('在庫詳細');
        //在庫情報表示確認
        $this->assertEquals('サンプル', $stock['shop']);
        $this->assertEquals('2021-04-12', $stock['purchase_date']);
        $this->assertEquals('2021-06-12', $stock['deadline']);
        $this->assertEquals('サンプル', $stock['name']);
        $this->assertEquals(200, $stock['price']);
        $this->assertEquals(10, $stock['number']);
        $this->assertEquals($file, $stock['image']);
    }

    //在庫レコード削除
    public function testDeleteFactoryTest()
    {
        //利用者アカウントでログインし利用者用の在庫一覧画面へ遷移
        $user = User::factory(User::class)->create([
            'id' => 7,
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        $response = $this->actingAs($user)->get('/list');

        //在庫を作成してログアウト
        $stock = Stock::factory(Stock::class)->create();
        $this->post('logout');

        //管理者アカウントでログインして管理者用の在庫一覧画面へ遷移
        $adminUser = User::factory(User::class)->create([
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        $response = $this->actingAs($adminUser)->get('/admin/list');

        //在庫削除
        $stock->delete();

        //削除されているか確認
        $this->assertDeleted($stock);
    }

    //在庫レコード検索
    public function testSeachFactoryTest()
    {
        //利用者アカウントでログインし利用者用の在庫一覧画面へ遷移
        $user = User::factory(User::class)->create([
            'id' => 22,
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        $response = $this->actingAs($user)->get('/list');

        //在庫を作成してログアウト
        $stock = Stock::factory(Stock::class)->create([
            'shop' => 'サンプル',
            'purchase_date' => '2021-04-12',
            'deadline' => '2021-06-12',
            'name' => 'サンプル',
            'price' => 200,
            'number' => 10,
        ]);
        $this->post('logout');

        //管理者アカウントでログインして管理者用の在庫一覧画面へ遷移
        $adminUser = User::factory(User::class)->create([
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        $response = $this->actingAs($adminUser)->get('/admin/list');

        //ログイン状態で検索結果画面に検索ワードをpostして遷移
        $response = $this->actingAs($adminUser)->post('/admin/list/search', [
            'search' => 'サンプル',
        ]);

        //タイトルと検索結果のメッセージ表示確認
        $response->assertSee('在庫一覧');
        //検索結果の在庫情報表示確認
        $this->assertEquals('2021-06-12', $stock['deadline']);
        $this->assertEquals('サンプル', $stock['name']);
        $this->assertEquals(10, $stock['number']);
    }

    //アカウントレコード削除
    public function testAdminDeleteFactoryTest()
    {
        //管理者アカウントでログインしてアカウント一覧画面へ遷移
        $user = User::factory(User::class)->create([
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        $response = $this->actingAs($user)->get('/admin/userList');

        //アカウント作成
        $users = User::factory(User::class)->create();

        //アカウント削除
        $users->delete();

        //削除されているか確認
        $this->assertDeleted($users);
    }

    //アカウントレコード検索
    public function testAdminSeachFactoryTest()
    {
        //管理者アカウントでログインしてアカウント一覧画面へ遷移
        $user = User::factory(User::class)->create([
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        $response = $this->actingAs($user)->get('/admin/userList');

        //アカウント作成
        $users = User::factory(User::class)->create();

        //アカウント検索画面に検索ワードをpostして画面遷移
        $response = $this->from('/admin/userList')->post('/admin/userList/search', [
            'search' => $users['name'],
        ]);

        //タイトル表示確認
        $response->assertSee('アカウント一覧');
        //検索結果のアカウント情報表示確認
        $response->assertSee($users['id']);
        $response->assertSee($users['name']);
        $response->assertSee($users['email']);
    }
}
