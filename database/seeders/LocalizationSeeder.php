<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Localization\Country;

class LocalizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::factory()->count(20)->create();
    }
}
