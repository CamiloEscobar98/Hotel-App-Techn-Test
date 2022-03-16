<?php

namespace App\Http\Controllers\Localization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Http\Resources\Localization\Country\CountryCollection;
use App\Http\Resources\Localization\Country\CountryShowResource;

use App\Models\Localization\Country;

class CountryController extends Controller
{
    /**
     * Get the attributes which are used in Validation.
     * 
     * @return array
     */
    protected $attributes = [
        'name' => "Country's name",
        'slug' => "Country's short name",
    ];

    /**
     * Display a listing of the Country.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new CountryCollection(Country::paginate(5));
    }

    /**
     * Display the specified Country.
     *
     * @param  int $country
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new CountryShowResource(Country::findOrFail($id));
    }

    /**
     * Store a specified Country.
     *
     * @param  int $country
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'unique:countries', 'max:80', 'min:4'],
            'slug' => ['required', 'unique:countries', 'max:4', 'min:2']
        ];

        $this->validate($request, $rules, [], $this->attributes);

        $data = $request->only(['name', 'slug']);

        try {
            $country = Country::create($data);
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The Country has not been created.', 'error_code' => $ex->getCode()]);
        }
        return response()->json(['message' => 'The country: ' . $country->name . ' has been created.']);
    }

    /**
     * Updating a specified Country.
     *
     * @param  int $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => ['unique:countries,name,' . $id, 'max:80', 'min:4'],
            'slug' => ['unique:countries,slug,' . $id, 'max:4', 'min:2']
        ];

        $this->validate($request, $rules, [], $this->attributes);

        $data = $request->only(['name', 'slug']);

        try {
            $country = Country::find($id);
            $country->update($data);
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The Country has not been updated.', 'error_code' => $ex->getCode()]);
        }
        return response()->json(['message' => 'The country: ' . $country->name . ' has been updated.']);
    }

    /**
     * Destroy a specified Country.
     * 
     * @param int $country
     * @return response
     */
    public function destroy($id)
    {
        try {
            $country = Country::findOrFail($id);
            $countryName = $country->name;
            $country->delete();
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The Country has not been deleted.', 'error_code' => $ex->getCode()], 501);
        }
        return response()->json(['message' => 'Success! The Country: ' . $countryName . ' has been deleted.'], 200);
    }
}
