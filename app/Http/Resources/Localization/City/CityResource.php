<?php

namespace App\Http\Resources\Localization\City;

use Illuminate\Http\Resources\Json\JsonResource;


class CityResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'country' => [
                'name' => $this->country->name,
                'url' => route('countries.show', ['id' => $this->country->id])
            ],
            'state' => [
                'name' => $this->state->name,
                'url' => route('states.show', ['id' => $this->state->id])
            ],
            'dates' => [
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ]
        ];
    }
}
