<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;

use App\Http\Resources\Configuration\RoomType\RoomTypeCollection;
use App\Http\Resources\Configuration\RoomType\RoomTypeResource;
use App\Models\Configuration\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{

    /**
     * Get the Attributes for the validation.
     * 
     * @return array
     */

    protected $attributes = ['name' => 'room type'];

    /**
     * Display the listing of teh RoomType.
     * 
     * @return Response
     */
    public function index()
    {
        return new RoomTypeCollection(RoomType::paginate(5));
    }

    /**
     * Display the information about RoomType.
     * 
     * @return Response
     */
    public function show($id)
    {
        return new RoomTypeResource(RoomType::findOrFail($id));
    }

    /**
     * Store a RoomType information.
     * 
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = ['name' => ['required', 'unique:room_types', 'max:80']];

        $this->validate($request, $rules, [], $this->attributes);

        $data = $request->only(['name']);

        try {
            $roomType = RoomType::create($data);
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The Room Type has not been created.', 'error_code' => $ex->getCode()], 500);
        }
        return response()->json(['message' => 'The Room Type: ' . $roomType->name . ' has been created.']);
    }


    /**
     * Update a RoomType information.
     * 
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $rules = ['name' => ['required', 'unique:room_types,id,' . $id, 'max:80']];

        $this->validate($request, $rules, [], $this->attributes);

        $data = $request->only(['name']);

        try {
            $roomType = RoomType::findOrFail($id);
            $roomType->update($data);
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The Room Type has not been updated.', 'error_code' => $ex->getCode()], 500);
        }
        return response()->json(['message' => 'The Room Type: ' . $roomType->name . ' has been updated.']);
    }

    /**
     * Delete a RoomType.
     * 
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $roomType = RoomType::findOrFail($id);
            $roomTypeName = $roomType->name;
            $roomType->delete();
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The Room Type has not been deleted.', 'error_code' => $ex->getCode()], 500);
        }
        return response()->json(['message' => 'Success! The Room Type: ' . $roomTypeName . ' has been deleted.'], 200);
    }
}
