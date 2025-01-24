<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('states')->insert([
            ['name' => 'Alabama', 'code' => 'AL', 'is_available' => true],
            ['name' => 'Alaska', 'code' => 'AK', 'is_available' => true],
            ['name' => 'Arizona', 'code' => 'AZ', 'is_available' => true],
            ['name' => 'Arkansas', 'code' => 'AR', 'is_available' => true],
            ['name' => 'California', 'code' => 'CA', 'is_available' => true],
            ['name' => 'Colorado', 'code' => 'CO', 'is_available' => true],
            ['name' => 'Connecticut', 'code' => 'CT', 'is_available' => true],
            ['name' => 'Delaware', 'code' => 'DE', 'is_available' => true],
            [
                'name' => 'District of Columbia',
                'code' => 'DC',
                'is_available' => true,
            ],
            ['name' => 'Florida', 'code' => 'FL', 'is_available' => true],
            ['name' => 'Georgia', 'code' => 'GA', 'is_available' => true],
            ['name' => 'Hawaii', 'code' => 'HI', 'is_available' => true],
            ['name' => 'Idaho', 'code' => 'ID', 'is_available' => true],
            ['name' => 'Illinois', 'code' => 'IL', 'is_available' => true],
            ['name' => 'Indiana', 'code' => 'IN', 'is_available' => true],
            ['name' => 'Iowa', 'code' => 'IA', 'is_available' => true],
            ['name' => 'Kansas', 'code' => 'KS', 'is_available' => true],
            ['name' => 'Kentucky', 'code' => 'KY', 'is_available' => true],
            ['name' => 'Louisiana', 'code' => 'LA', 'is_available' => true],
            ['name' => 'Maine', 'code' => 'ME', 'is_available' => true],
            ['name' => 'Maryland', 'code' => 'MD', 'is_available' => true],
            ['name' => 'Massachusetts', 'code' => 'MA', 'is_available' => true],
            ['name' => 'Michigan', 'code' => 'MI', 'is_available' => true],
            ['name' => 'Minnesota', 'code' => 'MN', 'is_available' => false],
            ['name' => 'Mississippi', 'code' => 'MS', 'is_available' => true],
            ['name' => 'Missouri', 'code' => 'MO', 'is_available' => true],
            ['name' => 'Montana', 'code' => 'MT', 'is_available' => true],
            ['name' => 'Nebraska', 'code' => 'NE', 'is_available' => true],
            ['name' => 'Nevada', 'code' => 'NV', 'is_available' => true],
            ['name' => 'New Hampshire', 'code' => 'NH', 'is_available' => true],
            ['name' => 'New Jersey', 'code' => 'NJ', 'is_available' => false],
            ['name' => 'New Mexico', 'code' => 'NM', 'is_available' => true],
            ['name' => 'New York', 'code' => 'NY', 'is_available' => true],
            [
                'name' => 'North Carolina',
                'code' => 'NC',
                'is_available' => true,
            ],
            ['name' => 'North Dakota', 'code' => 'ND', 'is_available' => true],
            ['name' => 'Ohio', 'code' => 'OH', 'is_available' => true],
            ['name' => 'Oklahoma', 'code' => 'OK', 'is_available' => true],
            ['name' => 'Oregon', 'code' => 'OR', 'is_available' => true],
            ['name' => 'Pennsylvania', 'code' => 'PA', 'is_available' => true],
            ['name' => 'Rhode Island', 'code' => 'RI', 'is_available' => true],
            [
                'name' => 'South Carolina',
                'code' => 'SC',
                'is_available' => true,
            ],
            ['name' => 'South Dakota', 'code' => 'SD', 'is_available' => true],
            ['name' => 'Tennessee', 'code' => 'TN', 'is_available' => true],
            ['name' => 'Texas', 'code' => 'TX', 'is_available' => true],
            ['name' => 'Utah', 'code' => 'UT', 'is_available' => true],
            ['name' => 'Vermont', 'code' => 'VT', 'is_available' => true],
            ['name' => 'Virginia', 'code' => 'VA', 'is_available' => true],
            ['name' => 'Washington', 'code' => 'WA', 'is_available' => true],
            ['name' => 'West Virginia', 'code' => 'WV', 'is_available' => true],
            ['name' => 'Wisconsin', 'code' => 'WI', 'is_available' => false],
            ['name' => 'Wyoming', 'code' => 'WY', 'is_available' => true],
        ]);
    }
}
