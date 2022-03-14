<?php

namespace App\Http\Resources\Localization\State;

use Illuminate\Http\Resources\Json\JsonResource;


class StateResource extends JsonResource
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
            'cities' => $this->cities()->count(),
            'dates' => [
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ]
        ];
    }
}
