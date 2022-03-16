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
            'hotel' => [
                'nit' => $this->room->hotel->nit,
                'name' => $this->room->hotel->name,
                'url' => route('hotels.show', ['id' => $this->room->hotel->id])
            ],
            'room_type' => [
                'name' => $this->room->roomType->name,
                'url' => route('room_types.show', ['id' => $this->room->roomType->id])
            ],
            'accommodation_type' => [
                'name' => $this->room->accommodationType->name,
                'url' => route('accommodation_types.show', ['id' => $this->room->accommodationType->id])
            ]
        ];
    }
}
