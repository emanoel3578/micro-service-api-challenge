<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transfer')->insert([
            'created_at' => Carbon::now(),
            'user_id' => 1
        ]);
        DB::table('transfer')->insert([
            'created_at' => Carbon::now(),
            'user_id' => 2
        ]);
        DB::table('transfer')->insert([
            'created_at' => Carbon::now(),
            'user_id' => 3
        ]);
        DB::table('transfer')->insert([
            'created_at' => Carbon::now(),
            'user_id' => 4
        ]);
        DB::table('transfer')->insert([
            'created_at' => Carbon::now(),
            'user_id' => 5
        ]);
        DB::table('transfer')->insert([
            'created_at' => Carbon::now(),
            'user_id' => 6,
            'updated_at' => Carbon::now()
        ]);
        DB::table('transfer')->insert([
            'created_at' => Carbon::now(),
            'user_id' => 7,
            'updated_at' => Carbon::now()
        ]);
        DB::table('transfer')->insert([
            'created_at' => Carbon::now(),
            'user_id' => 8,
            'updated_at' => Carbon::now()
        ]);
    }
}
