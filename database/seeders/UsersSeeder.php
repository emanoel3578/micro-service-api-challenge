<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            'id' => 1,
            'name' => 'userTest'
        ]);
        DB::table('user')->insert([
            'id' => 2,
            'name' => 'userTest2'
        ]);
        DB::table('user')->insert([
            'id' => 3,
            'name' => 'userTest3'
        ]);
        DB::table('user')->insert([
            'id' => 4,
            'name' => 'userTest4'
        ]);
        DB::table('user')->insert([
            'id' => 5,
            'name' => 'userTest5'
        ]);
        DB::table('user')->insert([
            'id' => 6,
            'name' => 'userTest6'
        ]);
        DB::table('user')->insert([
            'id' => 7,
            'name' => 'userTest7'
        ]);
        DB::table('user')->insert([
            'id' => 8,
            'name' => 'userTest8'
        ]);
    }
}
