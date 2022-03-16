<?php

namespace App\Http\Resources\Hotel;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomsByHotelResource extends JsonResource
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
            'roomType' => [
                'name' => $this->roomType->name,
                'url' => route('room_types.show', ['id' => $this->roomType->id]),
            ],
            'accommodationType' => [
                'name' => $this->accommodationType->name,
                'url' => route('accommodation_types.show', ['id' => $this->accommodationType->id]),
            ],
            'ammount_rooms' => $this->ammount_rooms
        ];
    }
}
