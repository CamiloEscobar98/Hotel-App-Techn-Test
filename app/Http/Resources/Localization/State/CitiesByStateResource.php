<?php

namespace App\Http\Resources\Localization\State;

use Illuminate\Http\Resources\Json\JsonResource;


class CitiesByStateResource extends JsonResource
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
            'url' => route('cities.show', ['id' => $this->id]),
            'dates' => [
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ]
        ];
    }
}
