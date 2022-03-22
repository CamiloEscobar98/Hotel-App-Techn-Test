<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

use App\Http\Resources\Configuration\AssignmentRoomType\AssignmentRoomTypeCollection;
use App\Http\Resources\Configuration\AssignmentRoomType\AssignmentRoomTypeResource;

use App\Models\Configuration\AssignmentRoomType;

class AssignmentRoomTypeController extends Controller
{

    /**
     * Get the Attributes for the validation.
     * 
     * @return array
     */

    protected $attributes = ['room_type_id' => 'room type', 'accommodation_type_id' => 'accommodation_type'];

    /**
     * Display the listing of teh AssignmentRoomType.
     * 
     * @return Response
     */
    public function index()
    {
        return new AssignmentRoomTypeCollection(AssignmentRoomType::orderby('room_type_id', 'ASC')->paginate(10));
    }

    /**
     * Display the information about AssignmentRoomType.
     * 
     * @return Response
     */
    public function show($id)
    {
        return new AssignmentRoomTypeResource(AssignmentRoomType::findOrFail($id));
    }

    /**
     * Store a AssignmentRoomType information.
     * 
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = [
            'room_type_id' => [
                'required',
                Rule::unique('assignment_accommodation_room_type', 'room_type_id')->where(function ($query) use ($request) {
                    return !$query->where('room_type_id', $request->room_type_id)->where('accommodation_type_id', $request->accommodation_type_id);
                }),
                'exists:room_types,id'
            ],
            'accommodation_type_id' => ['required', 'exists:accommodation_types,id']
        ];

        $this->validate($request, $rules, [], $this->attributes);

        $data = $request->only(['room_type_id', 'accommodation_type_id']);

        try {
            $assignmentRoomType = AssignmentRoomType::create($data);
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The Assignment Room Type has not been created.', 'error_code' => $ex->getCode()], 500);
        }
        return response()->json(['message' => 'The Assignment Room Type has been created. :' . $assignmentRoomType->roomType->name . ': with :' . $assignmentRoomType->accommodationType->name . ':']);
    }


    /**
     * Update a AssignmentRoomType information.
     * 
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'room_type_id' => [
                'required',
                Rule::unique('assignment_accommodation_room_type', 'room_type_id')->where(function ($query) use ($request, $id) {
                    return !$query->where('room_type_id', $request->room_type_id)->where('accommodation_type_id', $request->accommodation_type_id)->where('id', $id);
                }),
                'exists:room_types,id'
            ],
            'accommodation_type_id' => ['required', 'exists:accommodation_types,id']
        ];

        $this->validate($request, $rules, [], $this->attributes);

        $data = $request->only(['room_type_id', 'accommodation_type_id']);

        try {
            $assignmentRoomType = AssignmentRoomType::findOrFail($id);
            $assignmentRoomType->update($data);
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The Assignment Room Type has not been updated.', 'error_code' => $ex->getCode()], 500);
        }
        return response()->json(['message' => 'The Assignment Room Type has been updated.']);
    }

    /**
     * Delete a AssignmentRoomType.
     * 
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $assignmentRoomType = AssignmentRoomType::findOrFail($id);
            $assignmentRoomTypeName = $assignmentRoomType->name;
            $assignmentRoomType->delete();
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The Assignment Room Type has not been deleted.', 'error_code' => $ex->getCode()], 500);
        }
        return response()->json(['message' => 'Success! The Assignment Room Type has been deleted.'], 200);
    }
}
