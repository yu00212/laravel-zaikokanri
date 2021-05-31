<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StockTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    public function test_index()
    {
        $this->visit('/list')->see('在庫一覧');
        $response->assertStatus(302);
    }

    public function test_example()
    {
        $response = $this->get('/list');
        $response->assertStatus(302);
    }

    public function test_add_screen_can_be_rendered()
    {
        $response = $this->post('/list/add');
        $response->assertStatus(302);
    }

    public function test_new_stocks_can_add()
    {
        $response = $this->post('list/add', [
            'shop' => 'Test shop',
            'purchase_date' => '2021-10-10',
            'deadline' => '2021-12-12',
            'name' => 'Test Sample',
            'price' => '100',
            'number' => '3',
        ]);
    }
}
