<?php

namespace App\Http\Resources\Configuration\AccommodationType;

use Illuminate\Http\Resources\Json\ResourceCollection;

use App\Http\Resources\Configuration\AccommodationType\AccommodationTypeResource;

class AccommodationTypeCollection extends ResourceCollection
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = AccommodationTypeResource::class;

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
