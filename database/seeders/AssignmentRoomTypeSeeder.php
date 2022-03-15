<?php

namespace Database\Seeders;

use App\Models\Configuration\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssignmentRoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $standarRoomType = RoomType::where('name', 'estándar')->get()->first();
        $juniorRoomType = RoomType::where('name', 'junior')->get()->first();
        $suiteRoomType = RoomType::where('name', 'suite')->get()->first();

        $standarRoomType->accommodationTypes()->sync([1, 2]);

        $juniorRoomType->accommodationTypes()->sync([3, 4]);

        $suiteRoomType->accommodationTypes()->sync([1, 2, 3]);
    }
}
