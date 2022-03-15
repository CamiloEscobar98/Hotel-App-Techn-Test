<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoomTypeSeeder::class,
            AccommodationTypeSeeder::class,
            AssignmentRoomTypeSeeder::class,
            LocalizationSeeder::class,
            HotelSeeder::class,
            UserSeeder::class
        ]);
    }
}
