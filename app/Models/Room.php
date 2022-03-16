<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Hotel;
use App\Models\Configuration\AssignmentRoomType;
use App\Models\Configuration\RoomType;
use App\Models\Configuration\AccommodationType;

class Room extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rooms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['hotel_id', 'assignment_room_id', 'ammount_rooms'];

    /**
     * Get Hotel which is relationed with Room.
     * 
     * @return Hotel $hotel
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    /**
     * Get the AssignmentRoomType which is relationed with Room.
     * 
     * @return AssignmentRoomType $assignmentRoomType
     */
    public function assignmentRoomType()
    {
        return $this->belongsTo(AssignmentRoomType::class, 'assignment_room_id');
    }

    /**
     * Get the RoomType which is relationed with Room's AssignmentRoomType.
     * 
     * @return RoomType $roomType
     */
    public function roomType()
    {
        return $this->hasOneThrough(RoomType::class, AssignmentRoomType::class, 'id', 'id', 'assignment_room_id', 'room_type_id');
    }

    /**
     * Get the AccommodationType which is relationed with Room's AssignmentRoomType.
     * 
     * @return AccommodationType $accommodationType
     */
    public function accommodationType()
    {
        return $this->hasOneThrough(AccommodationType::class, AssignmentRoomType::class, 'id', 'id', 'assignment_room_id', 'accommodation_type_id');
    }
}
