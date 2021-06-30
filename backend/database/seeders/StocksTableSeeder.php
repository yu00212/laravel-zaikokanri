<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stock;

class StocksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Stock::factory()->count(15)->create();
        \Event::fakeFor(function () {
            Stock::factory()->count(20)->create();
        });
    }
}
