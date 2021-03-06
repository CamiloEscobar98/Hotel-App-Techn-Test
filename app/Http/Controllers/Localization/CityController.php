<?php

namespace App\Http\Controllers\Localization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

use App\Http\Resources\Localization\City\CityCollection;
use App\Http\Resources\Localization\City\CityShowResource;

use App\Models\Localization\City;

class CityController extends Controller
{

    /**
     * Get the attributes which are used in Validation.
     * 
     * @return array
     */
    protected  $attributes = [
        'state_id' => 'State',
        'name' => "City's name",
        'slug' => "City's short name",
    ];

    /**
     * Display a listing of the City.
     *
     * @return Response
     */
    public function index()
    {
        return new CityCollection(City::orderBy('state_id', 'ASC')->paginate(25));
    }

    /**
     * Display the specified City.
     *
     * @param  int $city
     * @return Response
     */
    public function show($id)
    {
        return new CityShowResource(City::findOrFail($id));
    }

    /**
     * Store a specified City.
     *
     * @param  int $city
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = [
            'state_id' => ['required', 'exists:states,id'],
            'name' => ['required', Rule::unique('cities', 'name')->where(function ($query) use ($request) {
                return !$query->where('name', $request->name)->where('state_id', $request->state_id);
            }), 'max:80', 'min:4'],
            'slug' => ['required', Rule::unique('cities', 'slug')->where(function ($query) use ($request) {
                return !$query->where('slug', $request->slug)->where('state_id', $request->state_id);
            }), 'max:4', 'min:2']
        ];



        $this->validate($request, $rules, [], $this->attributes);

        $data = $request->only(['name', 'slug', 'state_id']);

        try {
            $city = City::create($data);
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The City has not been created.', 'error_code' => $ex->getCode()]);
        }
        return response()->json(['message' => 'The City: ' . $city->name . ' has been created.']);
    }

    /**
     * Updating a specified City.
     *
     * @param  int $city
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'state_id' => ['exists:states'],
            'name' => [Rule::unique('cities', 'name')->where(function ($query) use ($request, $id) {
                return !$query->where('name', $request->name)->where('state_id', $request->state_id)->where('id', $id);
            }), 'max:80', 'min:4'],
            'slug' => [Rule::unique('cities', 'slug')->where(function ($query) use ($request, $id) {
                return !$query->where('slug', $request->slug)->where('state_id', $request->state_id)->where('id', $id);
            }), 'max:4', 'min:2']
        ];



        $this->validate($request, $rules, [], $this->attributes);

        $data = $request->only(['name', 'slug', 'state_id']);

        try {
            $city = City::find($id);
            $city->update($data);
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The City has not been updated.', 'error_code' => $ex->getCode()]);
        }
        return response()->json(['message' => 'The City: ' . $city->name . ' has been updated.']);
    }

    /**
     * Destroy a specified City.
     * 
     * @param int $city
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $city = City::findOrFail($id);
            $cityName = $city->name;
            $city->delete();
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The City has not been deleted.', 'error_code' => $ex->getCode()], 501);
        }
        return response()->json(['message' => 'Success! The City: ' . $cityName . ' has been deleted.'], 200);
    }
}
