<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Configuration\RoomType;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roomTypes = ['estándar', 'junior', 'suite'];
        foreach ($roomTypes as $roomType) {
            RoomType::create(['name' => $roomType]);
        }
    }
}
