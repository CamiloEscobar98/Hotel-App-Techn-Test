<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Room;
use App\Models\Configuration\AssignmentRoomType;

class RoomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Room::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $assignmentRoomTypeRandom = AssignmentRoomType::all()->random(1)->first();
        return [
            'assignment_room_id' => $assignmentRoomTypeRandom->id,
        ];
    }
}
