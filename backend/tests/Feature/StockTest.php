<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    public function testLoginScreenCanBeRendered()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function testListScreenCanBeRendered()
    {
        $response = $this->get('/list');
        $response->assertStatus(302);
    }

    public function testCanLogin(): void
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

    public function testAddScreenCanBeRendered()
    {
        $response = $this->get('/list/add');
        $response->assertStatus(302);

        $response = $this->post('/list/addCheck');
        $response->assertStatus(302);

        $response = $this->post('/list/addDone');
        $response->assertStatus(302);
    }

    public function testShowScreenCanBeRendered()
    {
        $response = $this->get('/list/show/{id}');
        $response->assertStatus(302);
    }

    public function testEditScreenCanBeRendered()
    {
        $response = $this->get('/list/edit/{id}');
        $response->assertStatus(302);

        $response = $this->post('/list/editCheck/{id}');
        $response->assertStatus(302);

        $response = $this->post('/list/editDone/{id}');
        $response->assertStatus(302);
    }

    public function testDelScreenCanBeRendered()
    {
        $response = $this->get('/list/delCheck/{id}');
        $response->assertStatus(302);

        $response = $this->post('/list/delDone/{id}');
        $response->assertStatus(302);
    }

    public function testSearchScreenCanBeRendered()
    {
        $response = $this->post('/list/search');
        $response->assertStatus(302);
    }

    //レコード追加・件数確認
    public function testInsertFactoryTest()
    {
        //ユーザー認証して在庫一覧画面へ画面遷移
        $user = User::factory(User::class)->create([
            'password' => bcrypt('password'),
        ]);
        $response = $this->actingAs($user)->get('/list');

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
        $user = User::factory(User::class)->create([
            'password' => bcrypt('password'),
        ]);
        $response = $this->actingAs($user)->get('/list');

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
        $user = User::factory(User::class)->create([
            'password' => bcrypt('password'),
        ]);
        $response = $this->actingAs($user)->get('/list');

        //フェイクディスクの作成
        Storage::fake('s3');

        //UploadedFileクラス用意
        $file = UploadedFile::fake()->image('dummy.jpg');

        //S3にアップロードする処理
        $file->storeAs('', 'dummy.jpg', ['disk' => 's3']);

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

        //S3にアップロードされたか確認。
        Storage::disk('s3')->assertExists('dummy.jpg');
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
        $user = User::factory(User::class)->create([
            'id' => 2,
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

        //S3にアップロードされたか確認。
        Storage::disk('s3')->assertExists('dummy.jpg');
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
        $user = User::factory(User::class)->create([
            'id' => 3,
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        $response = $this->actingAs($user)->get('/list');

        //フェイクディスクの作成
        Storage::fake('s3');

        //UploadedFileクラス用意
        $file = UploadedFile::fake()->image('dummy.jpg');

        //S3にアップロードする処理
        $file->storeAs('', 'dummy.jpg', ['disk' => 's3']);

        //在庫作成
        $stock = Stock::factory(Stock::class)->create([
            'image' => $file,
        ]);

        // /listからログイン状態で詳細画面に遷移
        $response = $this->actingAs($user)->get('/list/show/' . $stock['id']);

        //S3にアップロードされたか確認。
        Storage::disk('s3')->assertExists('dummy.jpg');

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
        $user = User::factory(User::class)->create([
            'id' => 4,
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

        //ログイン状態で検索結果画面に検索ワードをpostして遷移
        $response = $this->actingAs($user)->post('/list/search', [
            'search' => 'サンプル',
        ]);

        //S3にアップロードされたか確認。
        Storage::disk('s3')->assertExists('dummy.jpg');
        //タイトルとメッセージ表示確認
        $response->assertSee('在庫一覧');
        //検索結果表示確認
        $this->assertEquals('2021-06-12', $stock['deadline']);
        $this->assertEquals('サンプル', $stock['name']);
        $this->assertEquals(10, $stock['number']);
    }
}
