<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            ['dept_name' => 'Accounting Department'],
            ['dept_name' => 'Engineering Department'],
            ['dept_name' => 'IT Department']]);
    }
}
