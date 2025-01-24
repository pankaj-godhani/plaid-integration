<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IncomeSourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('income_sources')->insert([
            ['name' => 'Employer'],
            ['name' => 'Social Security'],
            ['name' => 'Self-employed'],
            ['name' => 'Retirement'],
            ['name' => 'Disability'],
        ]);
    }
}
