<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

//$this->call(BlogsTableSeeder::Class);

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Stock::factory()->count(3)->create();
    }

}
