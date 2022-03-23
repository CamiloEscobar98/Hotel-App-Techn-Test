<?php

namespace App\Http\Resources\Localization\Country;

use Illuminate\Http\Resources\Json\JsonResource;


class StatesByCountryResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'cities' => $this->cities()->count(),
            'url' => route('states.show', ['id' => $this->id]),
            'dates' => [
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ]
        ];
    }
}
