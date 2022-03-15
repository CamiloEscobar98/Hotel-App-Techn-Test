<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Hotel;
use App\Models\Room;
use App\Models\Localization\City;
use App\Models\Configuration\AssignmentRoomType;

class HotelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Hotel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nit' => $this->faker->uuid,
            'city_id' => City::all()->random(1)->first()->id,
            'name' => 'Decameron ' . $this->faker->unique()->word,
            'address' => $this->faker->unique()->address,
            'properties' => ['rooms_number_total' => rand(15, 80)]
        ];
    }

    /**
     * Configure the Factory
     * 
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Hotel $hotel) {
            $roomsNumberTotal = $hotel->properties->rooms_number_total;

            $randomQuantity = rand(1, 5);

            $cont = 0;
            $accumulateRooms = 0;
            $assignmentRoomType = AssignmentRoomType::all()->toArray();

            while ($cont < $randomQuantity) {
                $partOfRoomsTotal = $roomsNumberTotal / $randomQuantity;
                $randomRooms = rand(1, $partOfRoomsTotal);
                if ($accumulateRooms + $randomRooms >= $roomsNumberTotal) {
                    $randomRooms = $roomsNumberTotal - $accumulateRooms;
                }
                Room::create([
                    'hotel_id' => $hotel->id,
                    'assignment_room_id' => $assignmentRoomType[$cont]['id'],
                    'ammount_rooms' => $randomRooms
                ]);
                $accumulateRooms += $randomRooms;
                $cont++;
            }
        });
    }
}
