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

    public function testAdminInsertFactoryTest()
    {
        // ユーザー認証して画面遷移
        $user = User::factory(User::class)->create([
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        $response = $this->actingAs($user)->get('/admin/userList');

        //$email = 'abcd@gmail.com';
        $createUser = User::factory(User::class)->count(3)->create();
        $count = count($createUser);
        $this->assertEquals(3, $count);
        $response->assertSee('アカウント一覧');

        //foreach($createUser as $users){
            //$response->assertSee($users->id);
            //$response->assertSee($users->name);
            //$response->assertSee($users->email);
        //}
        //$this->assertEquals('サンプル', $users['name']);
        //$this->assertEquals(3, $users['id']);
        //$this->assertEquals('katou', $users['name']);
        //$this->assertEquals('abcd@gmail.com', $users['email']);
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


        $email = 'hoge123@gmail.com';
        $users = User::factory(User::class)->create([
            'name' => 'サンプル',
            'email' => $email,
        ]);

        $response = $this->from('/admin/userList')->post('/admin/userList/search', [
            'search' => 'サンプル',
        ]);

        $response->assertSee('アカウント検索');
        //$response->assertSee($users->id);
        $this->assertEquals('サンプル', $users['name']);
        //$response->assertSee($users->name);
        //$response->assertSee($users->email);
        $this->assertEquals('hoge123@gmail.com', $users['email']);

        $users->delete();
        $this->assertDeleted($users);

        //$this->assertEquals('2021-06-12', $users['id']);
        //$this->assertEquals('サンプル', $users['name']);
        //$this->assertEquals(10, $users['email']);
    }
}
