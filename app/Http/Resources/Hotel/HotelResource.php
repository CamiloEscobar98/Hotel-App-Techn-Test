<?php

namespace App\Http\Resources\Hotel;

use Illuminate\Http\Resources\Json\JsonResource;

class HotelResource extends JsonResource
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
            'number_of_rooms' => (int) $this->numberOfRooms()
        ];
    }
}
