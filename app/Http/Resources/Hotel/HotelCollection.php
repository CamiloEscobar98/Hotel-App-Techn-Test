<?php

namespace App\Http\Resources\Hotel;

use Illuminate\Http\Resources\Json\ResourceCollection;

use App\Http\Resources\Hotel\HotelResource;

class HotelCollection extends ResourceCollection 
{
     /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = HotelResource::class;

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
