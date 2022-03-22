<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;

use App\Http\Resources\Hotel\HotelCollection;
use App\Http\Resources\Hotel\HotelShowResource;

use App\Models\Hotel;
use Illuminate\Validation\Rule;

class HotelController extends Controller
{

    /**
     * Get the attributes which are used in the validation.
     * 
     * @return array
     */
    protected $attributes = ['city_id' => 'city', 'nit' => 'hotel nit'];

    /**
     * Display a listing of the Hotel.
     * 
     * @return Response
     */
    public function index()
    {
        return new HotelCollection(Hotel::paginate(5));
    }

    /**
     * Store a specified Hotel.
     *
     * @param  int $hotel
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nit' => ['required', 'unique:hotels', 'max:40', 'min:10', 'string'],
            'name' => ['required', Rule::unique('hotels', 'name')->where(function ($query) use ($request) {
                return !$query->where('city_id', $request->city_id);
            }), 'max:80', 'string'],
            'address' => ['required', 'max:150', 'string'],
            'city_id' => ['required', 'exists:cities,id'],
            'properties' => ['required', 'array']
        ];

        $request->properties = json_encode($request->properties);

        $this->validate($request, $rules, [], $this->attributes);

        $data = $request->only(['nit', 'name', 'address', 'city_id', 'properties']);

        if (empty($data['properties']['rooms_number_total'])) {
            $data['properties']['rooms_number_total'] = rand(1, 100);
        }

        try {
            $hotel = Hotel::create($data);
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The Hotel has not been created.', 'error_code' => $ex->getCode()]);
        }
        return response()->json(['message' => 'The Hotel: ' . $hotel->name . ' has been created.']);
    }

    /**
     * Display the specified Hotel.
     *
     * @param  int $hotel
     * @return Response
     */
    public function show($id)
    {
        return new HotelShowResource(Hotel::findOrFail($id));
    }

    /**
     * Updating a specified Hotel.
     *
     * @param  int $hotel
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $hotelAux = Hotel::findOrFail($id);
        $rules = [
            'nit' => ['unique:hotels,id,' . $id, 'max:40', 'min:10', 'string'],
            'name' => [Rule::unique('hotels', 'name')->where(function ($query) use ($request) {
                return !$query->where('city_id', $request->city_id);
            })->ignore($id), 'max:80', 'string'],
            'address' => ['max:150', 'string'],
            'city_id' => ['exists:cities,id'],
            'properties.rooms_number_total' => ['integer', 'min:' .  $hotelAux->numberOfRooms()]
        ];

        $this->validate($request, $rules, [], $this->attributes);

        $data = $request->only(['nit', 'name', 'address', 'city_id', 'properties']);

        try {
            $hotel = Hotel::findOrFail($id);
            $hotel->update($data);
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The Hotel has not been updated.', 'error_code' => $ex->getCode()]);
        }
        return response()->json(['message' => 'The Hotel: ' . $hotel->name . ' has been updated.']);
    }

    /**
     * Destroy a specified Hotel.
     * 
     * @param int $hotel
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $hotel = Hotel::findOrFail($id);
            $hotelName = $hotel->name;
            $hotel->delete();
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The Hotel has not been deleted.', 'error_code' => $ex->getCode()], 501);
        }
        return response()->json(['message' => 'Success! The Hotel: ' . $hotelName . ' has been deleted.'], 200);
    }
}
