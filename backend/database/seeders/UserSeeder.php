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

        \DB::table('users')->insert([
            'name' => '管理者',
            'email' => 'admin@test.com',
            'password' => \Hash::make('admin1234'),
            'role' => 'admin',
        ]);
    }
}
