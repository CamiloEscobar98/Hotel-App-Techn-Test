<?php

namespace Database\Seeders;

use App\Models\Configuration\AccommodationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccommodationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accommodationTypes = ['sencilla', 'doble', 'triple', 'cuadruple'];
        foreach ($accommodationTypes as $accommodationType) {
            AccommodationType::create(['name' => $accommodationType]);
        }
    }
}
