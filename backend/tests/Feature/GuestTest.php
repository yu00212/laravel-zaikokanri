<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Stock;
use App\Models\User;

class GuestTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function test_list_screen_can_be_rendered()
    {
        $response = $this->get('/guest/list');
        $response->assertStatus(302);
    }

    public function test_Can_Login(): void
    {
        $email = 'guest@test.com';
        $user = User::factory(User::class)->create([
            'email' => $email,
            'password' => bcrypt('password'),
            'role' => 'guest',
        ]);
        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertRedirect('/guest/list');
        $this->assertAuthenticatedAs($user);
    }

    public function test_add_screen_can_be_rendered()
    {
        $response = $this->get('/guest/list/add');
        $response->assertStatus(302);

        $response = $this->post('/guest/list/addCheck');
        $response->assertStatus(302);

        $response = $this->post('/guest/list/addDone');
        $response->assertStatus(302);
    }

    public function test_show_screen_can_be_rendered()
    {
        $response = $this->get('/guest/list/show/{id}');
        $response->assertStatus(302);
    }

    public function test_edit_screen_can_be_rendered()
    {
        $response = $this->get('/guest/list/edit/{id}');
        $response->assertStatus(302);

        $response = $this->post('/guest/list/editCheck/{id}');
        $response->assertStatus(302);

        $response = $this->post('/guest/list/editDone/{id}');
        $response->assertStatus(302);
    }

    public function test_del_screen_can_be_rendered()
    {
        $response = $this->get('/guest/list/delCheck/{id}');
        $response->assertStatus(302);

        $response = $this->post('/guest/list/delDone/{id}');
        $response->assertStatus(302);
    }

    public function test_search_screen_can_be_rendered()
    {
        $response = $this->post('/guest/list/search');
        $response->assertStatus(302);
    }

    //レコード追加・件数確認
    public function testInsertFactoryTest()
    {
        //ユーザー認証して在庫一覧画面へ画面遷移
        $email = 'guest@test.com';
        $user = User::factory(User::class)->create([
            'email' => $email,
            'password' => bcrypt('password'),
            'role' => 'guest',
        ]);
        $response = $this->actingAs($user)->get('/guest/list');

        //在庫作成
        $stocks = Stock::factory(Stock::class)->count(3)->create();

        //在庫の作成件数確認
        $count = count($stocks);
        $this->assertEquals(3, $count);
    }

    //レコード削除
    public function testDeleteFactoryTest()
    {
        //ユーザー認証して在庫一覧画面へ画面遷移
        $email = 'guest@test.com';
        $user = User::factory(User::class)->create([
            'email' => $email,
            'password' => bcrypt('password'),
            'role' => 'guest',
        ]);
        $response = $this->actingAs($user)->get('/guest/list');

        //在庫作成
        $stock = Stock::factory(Stock::class)->create();

        //在庫削除
        $stock->delete();

        //削除されているか確認
        $this->assertDeleted($stock);
    }

    //レコード更新
    public function testUpdateFactoryTest()
    {
        //ユーザー認証して在庫一覧画面へ画面遷移
        $email = 'guest@test.com';
        $user = User::factory(User::class)->create([
            'email' => $email,
            'password' => bcrypt('password'),
            'role' => 'guest',
        ]);
        $response = $this->actingAs($user)->get('/guest/list');

        //フェイクディスクの作成
        //storage/framework/testing/disks/stocksに保存用ディスクが作成される
        Storage::fake('stocks');

        //UploadedFileクラス用意
        $file = UploadedFile::fake()->image('stock.jpg');

        //作成した画像を移動
        $file->move('storage/framework/testing/disks/stocks');

        //在庫作成
        $stock = Stock::factory(Stock::class)->create([
            'image' => $file,
        ]);

        //在庫情報を更新
        $stock->update([
            'shop' => 'サンプル',
            'purchase_date' => '2021-04-12',
            'deadline' => '2021-06-12',
            'name' => 'サンプル',
            'price' => 200,
            'number' => 10,
            'image' => $file,
        ]);

        //在庫情報の表示確認
        $this->assertEquals('サンプル', $stock['shop']);
        $this->assertEquals('2021-04-12', $stock['purchase_date']);
        $this->assertEquals('2021-06-12', $stock['deadline']);
        $this->assertEquals('サンプル', $stock['name']);
        $this->assertEquals(200, $stock['price']);
        $this->assertEquals(10, $stock['number']);
        $this->assertEquals($file, $stock['image']);
    }

    //レコード一覧表示
    public function testListFactoryTest()
    {
        //ユーザー認証して在庫一覧画面へ画面遷移
        $email = 'guest@test.com';
        $user = User::factory(User::class)->create([
            'id' => 2,
            'email' => $email,
            'password' => bcrypt('password'),
            'role' => 'guest',
        ]);
        $response = $this->actingAs($user)->get('/guest/list');

        //フェイクディスクの作成
        //storage/framework/testing/disks/stocksに保存用ディスクが作成される
        Storage::fake('stocks');

        //UploadedFileクラス用意
        $file = UploadedFile::fake()->image('stock.jpg');

        //作成した画像を移動
        $file->move('storage/framework/testing/disks/stocks');

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

        //画像データ保存確認
        Storage::disk('stocks')->assertExists($file->getFileName());
        //タイトル表示確認
        $response->assertSee('在庫一覧');
        //在庫情報表示確認
        $this->assertEquals('2021-06-12', $stock['deadline']);
        $this->assertEquals('サンプル', $stock['name']);
        $this->assertEquals(10, $stock['number']);
    }

    //レコード詳細表示
    public function testShowFactoryTest()
    {
        //ログインユーザーを作成して画面遷移
        $email = 'guest@test.com';
        $user = User::factory(User::class)->create([
            'id' => 3,
            'email' => $email,
            'password' => bcrypt('password'),
            'role' => 'guest',
        ]);
        $response = $this->actingAs($user)->get('/guest/list');

        //フェイクディスクの作成
        //storage/framework/testing/disks/stocksに保存用ディスクが作成される
        Storage::fake('stocks');

        //UploadedFileクラス用意
        $file = UploadedFile::fake()->image('stock.jpg');

        //作成した画像を移動
        $file->move('storage/framework/testing/disks/stocks');

        //在庫作成
        $stock = Stock::factory(Stock::class)->create([
            'image' => $file,
        ]);

        // /listからログイン状態で詳細画面に遷移
        $response = $this->actingAs($user)->get('/guest/list/show/'.$stock['id']);

        //画像データ保存確認
        Storage::disk('stocks')->assertExists($file->getFileName());
        //タイトル表示確認
        $response->assertSee('在庫詳細');
        //在庫情報表示確認
        $response->assertSee($stock['shop']);
        $response->assertSee($stock['purchase_date']->format('Y-m-d'));
        $response->assertSee($stock['deadline']->format('Y-m-d'));
        $response->assertSee($stock['name']);
        $response->assertSee($stock['price']);
        $response->assertSee($stock['number']);
        $response->assertSee($stock['image']);
    }

    //レコード検索
    public function testSeachFactoryTest()
    {
        $email = 'guest@test.com';
        $user = User::factory(User::class)->create([
            'id' => 4,
            'email' => $email,
            'password' => bcrypt('password'),
            'role' => 'guest',
        ]);
        $response = $this->actingAs($user)->get('/guest/list');

        //フェイクディスクの作成
        //storage/framework/testing/disks/stocksに保存用ディスクが作成される
        Storage::fake('stocks');

        //UploadedFileクラス用意
        $file = UploadedFile::fake()->image('stock.jpg');

        //作成した画像を移動
        $file->move('storage/framework/testing/disks/stocks');

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

        //ログイン状態で検索結果画面に検索ワードをpostして遷移
        $response = $this->actingAs($user)->post('/guest/list/search', [
            'search' => 'サンプル',
        ]);

        //画像データ保存確認
        Storage::disk('stocks')->assertExists($file->getFileName());
        //タイトルとメッセージ表示確認
        $response->assertSee('在庫検索');
        $response->assertSee('該当商品がありました');
        //検索結果表示確認
        $this->assertEquals('2021-06-12', $stock['deadline']);
        $this->assertEquals('サンプル', $stock['name']);
        $this->assertEquals(10, $stock['number']);
    }
}
