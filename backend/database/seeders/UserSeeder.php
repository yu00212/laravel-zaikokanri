<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            'name' => 'ホシ',
            'email' => 'hoshi1234@test.com',
            'password' => \Hash::make('hoshi1234'),
        ]);
    }
}
