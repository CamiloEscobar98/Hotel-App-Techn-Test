<?php

namespace App\Http\Resources\Hotel;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Hotel\RoomsByHotelResource;

class HotelShowResource extends JsonResource
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
            'id' => $this->id,
            'nit' => $this->nit,
            'name' => $this->name,
            'address' => $this->address,
            'properties' => $this->properties,
            'city' => [
                'id' => $this->city_id,
                'name' => $this->city->name,
                'slug' => $this->city->slug,
                'url' => route('cities.show', ['id' => $this->city_id])
            ],
            'number_of_rooms' => (int) $this->rooms()->sum('ammount_rooms'),
            'max_number_of_rooms' => $this->numberOfRooms(),
            'rooms' => RoomsByHotelResource::collection($this->rooms)

        ];
    }
}
