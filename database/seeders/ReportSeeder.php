<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('report')->insert([
            'id' => 5,
            'sql' => 'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id',
        ]);
        DB::table('report')->insert([
            'id' => 6,
            'sql' => 'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id',
        ]);
        DB::table('report')->insert([
            'id' => 7,
            'sql' => 'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id',
        ]);
        DB::table('report')->insert([
            'id' => 8,
            'sql' => 'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id where t.created_at > dateStart',
        ]);
        DB::table('report')->insert([
            'id' => 9,
            'sql' => 'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id where t.updated_at > dateStart',
        ]);
        DB::table('report')->insert([
            'id' => 10,
            'sql' => 'Select u.name, t.created_at from user u inner join transfer t on u.id = t.user_id where t.created_at between dateStart and dateEnd',
        ]);
    }
}
