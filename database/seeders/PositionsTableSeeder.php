<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('positions')->insert([
        [
            'position_name' => 'Programmer 1',
            'salary' => 20000,
        ],
        [
            'position_name' => 'Engineer 1',
            'salary' => 25000,
        ],
        [
            'position_name' => 'Accounting 1',
            'salary' => 20000,
        ]]);
    }
}
