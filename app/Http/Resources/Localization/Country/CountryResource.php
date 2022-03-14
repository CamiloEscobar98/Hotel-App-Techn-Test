<?php

namespace App\Http\Resources\Localization\Country;

use Illuminate\Http\Resources\Json\JsonResource;


class CountryResource extends JsonResource
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
            'states' => $this->states()->count(),
            'cities' => $this->cities()->count(),
            'dates' => [
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ]
        ];
    }
}
