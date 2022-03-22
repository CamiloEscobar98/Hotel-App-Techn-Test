<?php

namespace App\Http\Resources\Configuration\AssignmentRoomType;

use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentRoomTypeResource extends JsonResource
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
            'room_type' => [
                'id' => $this->roomType->id,
                'name' => $this->roomType->name,
                'url' => route('room_types.show', ['id' => $this->room_type_id])
            ],
            'accommodation_type' => [
                'id' => $this->accommodationType->id,
                'name' => $this->accommodationType->name,
                'url' => route('accommodation_types.show', ['id' => $this->accommodation_type_id])
            ],
            'dates' => [
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ]
        ];
    }
}
