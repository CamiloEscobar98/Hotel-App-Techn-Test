<?php

namespace App\Http\Resources\Localization\Country;

use Illuminate\Http\Resources\Json\ResourceCollection;

use App\Http\Resources\Localization\Country\CountryResource;

class CountryCollection extends ResourceCollection
{

    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = CountryResource::class;

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
