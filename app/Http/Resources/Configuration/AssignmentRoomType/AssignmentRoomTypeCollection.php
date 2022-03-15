<?php

namespace App\Http\Resources\Configuration\AssignmentRoomType;

use Illuminate\Http\Resources\Json\ResourceCollection;

use App\Http\Resources\Configuration\AssignmentRoomType\AssignmentRoomTypeResource;

class AssignmentRoomTypeCollection extends ResourceCollection
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = AssignmentRoomTypeResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}
