<?php

namespace App\Http\Resources\Localization\City;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Localization\State\CitiesByStateResource;

class CityShowResource extends JsonResource
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
            'dates' => [
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ]
        ];
    }
}
