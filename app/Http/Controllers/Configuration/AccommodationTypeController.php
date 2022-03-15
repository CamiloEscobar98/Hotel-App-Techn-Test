<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Http\Resources\Configuration\AccommodationType\AccommodationTypeCollection;
use App\Http\Resources\Configuration\AccommodationType\AccommodationTypeResource;

use App\Models\Configuration\AccommodationType;

class AccommodationTypeController extends Controller
{
    /**
     * Get the Attributes for the validation.
     * 
     * @return array
     */

    protected $attributes = ['name' => 'accommodation type'];

    /**
     * Display the listing of teh Accommodation Type.
     * 
     * @return Response
     */
    public function index()
    {
        return new AccommodationTypeCollection(AccommodationType::paginate(5));
    }

    /**
     * Display the information about Accommodation Type.
     * 
     * @return Response
     */
    public function show($id)
    {
        return new AccommodationTypeResource(AccommodationType::findOrFail($id));
    }

    /**
     * Store a AccommodationType information.
     * 
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = ['name' => ['required', 'unique:accommodation_types', 'max:80']];

        $this->validate($request, $rules, [], $this->attributes);

        $data = $request->only(['name']);

        try {
            $accommodationType = AccommodationType::create($data);
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The Accommodation Type has not been created.', 'error_code' => $ex->getCode()], 500);
        }
        return response()->json(['message' => 'The Accommodation Type: ' . $accommodationType->name . ' has been created.']);
    }


    /**
     * Update a AccommodationType information.
     * 
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $rules = ['name' => ['required', 'unique:accommodation_types,id,' . $id, 'max:80']];

        $this->validate($request, $rules, [], $this->attributes);

        $data = $request->only(['name']);

        try {
            $accommodationType = AccommodationType::findOrFail($id);
            $accommodationType->update($data);
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The Accommodation Type has not been updated.', 'error_code' => $ex->getCode()], 500);
        }
        return response()->json(['message' => 'The Accommodation Type: ' . $accommodationType->name . ' has been updated.']);
    }

    /**
     * Delete a Accommodation Type.
     * 
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $accommodationType = AccommodationType::findOrFail($id);
            $accommodationTypeName = $accommodationType->name;
            $accommodationType->delete();
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The Accommodation Type has not been deleted.', 'error_code' => $ex->getCode()], 500);
        }
        return response()->json(['message' => 'Success! The Accommodation Type: ' . $accommodationTypeName . ' has been deleted.'], 200);
    }
}
