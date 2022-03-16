<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;

use App\Http\Resources\Room\RoomCollection;
use App\Http\Resources\Room\RoomResource;

use App\Models\Room;
use App\Models\Hotel;

class RoomController extends Controller
{
    /**
     * Get the attributes which are used in the validation.
     * 
     * @return array
     */
    protected $attributes = ['hotel_id' => 'hotel'];

    /**
     * Display a listing of the Room.
     * 
     * @return Response
     */
    public function index()
    {
        return new RoomCollection(Room::orderBy('hotel_id', 'ASC')->paginate(5));
    }

    /**
     * Store a specified Room.
     *
     * @param  int $room
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['hotel_id' => ['required', 'exists:hotels,id']], [], $this->attributes);

        $hotel = Hotel::findOrFail($request->hotel_id);


        $rules = [
            'hotel_id' => ['required', 'exists:hotels,id', Rule::unique('rooms', 'hotel_id')->where(function ($query) use ($request) {
                return !$query->where('assignment_room_id', $request->assignment_room_id);
            })],
            'assignment_room_id' => ['required', 'exists:assignment_accommodation_room_type,id'],
            'ammount_rooms' => ['required', 'integer', 'min:1', 'max:' . $hotel->properties->rooms_number_total - $hotel->numberOfRooms()],
        ];

        $request->properties = json_encode($request->properties);

        $this->validate($request, $rules, [], $this->attributes);

        $data = $request->only(['hotel_id', 'assignment_room_id', 'ammount_rooms']);

        try {
            $room = Room::create($data);
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The Room has not been created.', 'error_code' => $ex->getCode()]);
        }
        return response()->json(['message' => 'The Room: ' . $room->name . ' has been created.']);
    }

    /**
     * Display the specified Room.
     *
     * @param  int $room
     * @return Response
     */
    public function show($id)
    {
        return new RoomResource(Room::findOrFail($id));
    }

    /**
     * Updating a specified Room.
     *
     * @param  int $room
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, ['hotel_id' => ['required', 'exists:hotels,id']], [], $this->attributes);

        $hotel = Hotel::findOrFail($request->hotel_id);

        $rules = [
            'hotel_id' => ['exists:hotels,id', Rule::unique('rooms', 'hotel_id')->where(function ($query) use ($request) {
                return !$query->where('assignment_room_id', $request->assignment_room_id);
            })->ignore($id), 'max:80', 'string'],
            'assignment_room_id' => ['exists:assignment_accommodation_room_type,id'],
            'ammount_rooms' => ['required', 'integer', 'min:1', 'max:' . $hotel->properties->rooms_number_total - $hotel->numberOfRooms()],
        ];

        $this->validate($request, $rules, [], $this->attributes);

        $data = $request->only(['hotel_id', 'assignment_room_id', 'ammount_rooms']);

        try {
            $room = Room::findOrFail($id);
            $room->update($data);
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The Room has not been created.', 'error_code' => $ex->getCode()]);
        }
        return response()->json(['message' => 'The Room: ' . $room->name . ' has been created.']);
    }

    /**
     * Destroy a specified Room.
     * 
     * @param int $room
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $room = Room::findOrFail($id);
            $roomName = $room->name;
            $room->delete();
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error! The Room has not been deleted.', 'error_code' => $ex->getCode()], 501);
        }
        return response()->json(['message' => 'Success! The Room: ' . $roomName . ' has been deleted.'], 200);
    }
}
