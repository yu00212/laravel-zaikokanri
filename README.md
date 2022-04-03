# アプリ名：ZAIKO
![b21ae96eae424d638e635f50d6e30695](https://user-images.githubusercontent.com/72062892/142752997-37615487-9faf-439c-9806-9a6fed739dea.gif)

# 概要
自宅の日用品や食品の在庫を管理するアプリです。在庫の登録、表示、編集、削除、検索機能がスムーズに行えます。

下記リンクからログインができます。（ゲストログインあり）

https://zaiko-home.com/login

# このアプリを作成した理由
日常生活で、母が自宅の日用品や食品の管理に困っていました。

買い出し先で自宅の在庫状況が確認できず買い忘れをしたり、気づかない内に食品の消費期限が切れてしまい、そのまま捨てざるを得ないといった状況を多々目の当たりにしてきました。

そんな母の悩みを解決したいと思いこのアプリを作成しました。

# 工夫した点
- 顧客である母と実際にヒアリングを行い、フィードバックをもらいながら要望に合わせて機能を実装。
- ユーザーが操作に困ることなく使いやすいUIになるようシンプルなデザインを実装。
- スマホ一つで利用できるようにレスポンシブ対応。
- 実務を想定し、branch、issue、Pullrequestsを活用した擬似共同開発。
- PSR2のコーディング規約に沿ったソースコードで実装。
- ゲスト、利用者、管理者権限ごとに各機能のテストコードを実装。

# 機能一覧（全14機能）
- ユーザー認証
   - アカウント作成、詳細表示、編集、削除
   - ログイン（ゲスト、利用者、管理者）、ログアウト
   - アカウントの一覧表示（ペジネーションあり）
   - キーワードで曖昧検索

- 在庫管理
   - 在庫の登録、詳細表示、編集、削除（画像アップロードあり）
   - 一覧表示（ペジネーションあり）
   - キーワードで曖昧検索

# ER図
<img width="905" alt="スクリーンショット 2021-09-11 22 44 10" src="https://user-images.githubusercontent.com/72062892/132950115-98028519-e5ae-4906-a375-bfa0611272b8.png">

# 画面遷移図
<img width="1176" alt="スクリーンショット 2021-09-13 1 50 36" src="https://user-images.githubusercontent.com/72062892/132996122-3335c522-c7e1-4b8d-a010-b835d0a3422b.png">

# インフラ構成図
<img width="536" alt="スクリーンショット 2022-03-24 0 47 17" src="https://user-images.githubusercontent.com/72062892/159742186-5aa914a6-4837-46e4-986c-f48c488b2ca6.png">

# テストコード

ゲスト、利用者、管理者権限ごとに各機能のHTTPリクエスト、データベースのテストを実装。※一部記載。

```php
    //HTTPリクエスト
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
```

```php
　　　　　　　　//ログイン認証テスト
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
```

```php
　　　　　　　　//管理者画面での在庫詳細表示テスト
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
```

<img width="601" alt="スクリーンショット 2021-11-27 17 14 31" src="https://user-images.githubusercontent.com/72062892/143798463-df3a1e10-12ae-438f-b53f-70951674e823.png">

# 使用技術

フロントエンド：HTML5、CSS、bootstrap4.5.0、Tailwindcss2.2.15

バックエンド：PHP7.4.15、Laravel8.34.0、Jetstream1.0、Livewire

インフラ：Docker20.10.2、nginx1.18、MySQL8.0.23/phpMyAdmin、Apache2.4.38、AWS EC2 ALB S3 RDS

デプロイ：GitHubActions（CI/CD） Deployer
