<?php

namespace App\Http\Resources\Localization\State;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Localization\State\CitiesByStateResource;

class StateShowResource extends JsonResource
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
            'cities' => CitiesByStateResource::collection($this->cities),
            'dates' => [
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ]
        ];
    }
}
