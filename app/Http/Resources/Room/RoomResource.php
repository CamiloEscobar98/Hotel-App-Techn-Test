<?php

namespace App\Http\Resources\Room;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'assignment_room_id' => $this->assignmentRoomType->id,
            'hotel' => [
                'nit' => $this->hotel->nit,
                'name' => $this->hotel->name,
                'url' => route('hotels.show', ['id' => $this->hotel->id])
            ],
            'room_type' => [
                'name' => $this->roomType->name,
                'url' => route('room_types.show', ['id' => $this->roomType->id])
            ],
            'accommodation_type' => [
                'name' => $this->accommodationType->name,
                'url' => route('accommodation_types.show', ['id' => $this->accommodationType->id])
            ]
        ];
    }
}
