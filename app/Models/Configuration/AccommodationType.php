<?php

namespace App\Models\Configuration;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Models\Room;
use App\Models\Configuration\RoomType;

class AccommodationType extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'accommodation_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Set the AccommodationType's name.
     *
     * @param  string  $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        return $this->attributes['name'] = Str::lower($value);
    }

    /**
     * Get the AccommodationType's name.
     *
     * @param  string  $value
     * @return string
     */
    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * Get the Room list which is relationd with RoomType.
     * 
     * @return Room[] $rooms
     */
    public function rooms()
    {
        return $this->hasManyThrough(Room::class, AssignmentRoomType::class, 'id', 'id', 'accommodation_type_id', 'assignment_room_id');
    }

    /**
     * Get the RoomType list which is relationed with AccommodationType.
     * 
     * @return RoomType[] $roomTypes
     */
    public function roomTypes()
    {
        return $this->belongsToMany(RoomType::class, 'assignment_accommodation_room_type', 'accommodation_type_id', 'room_type_id');
    }
}
