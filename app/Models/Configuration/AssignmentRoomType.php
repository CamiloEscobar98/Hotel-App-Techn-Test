<?php

namespace App\Models\Configuration;

use Illuminate\Database\Eloquent\Model;

use App\Models\Configuration\RoomType;
use App\Models\Configuration\AccommodationType;

class AssignmentRoomType extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'assignment_accommodation_room_type';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['room_type_id', 'accommodation_type_id'];

    /**
     * Get RoomType which is relationed with Room.
     * 
     * @return RoomType $roomType
     */
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    /**
     * Get AccommodationType which is relationed with Room.
     * 
     * @return RoomType $accommodationType
     */
    public function accommodationType()
    {
        return $this->belongsTo(AccommodationType::class);
    }

    /**
     * Get the Room list which is relationd with RoomType.
     * 
     * @return Room[] $rooms
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
