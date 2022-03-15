<?php

namespace App\Models\Configuration;

use App\Models\Room;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RoomType extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'room_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Set the RoomType's name.
     *
     * @param  string  $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        return $this->attributes['name'] = Str::lower($value);
    }

    /**
     * Get the RoomType's name.
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
        return $this->hasManyThrough(Room::class, AssignmentRoomType::class, 'id', 'id', 'room_type_id', 'assignment_room_id');
    }

     /**
     * Get the AccommodationType list which is relationed with RoomType.
     * 
     * @return AccommodationType[] $accommodationTypes
     */
    public function accommodationTypes()
    {
        return $this->belongsToMany(AccommodationType::class, 'assignment_accommodation_room_type', 'room_type_id', 'accommodation_type_id')->withTimestamps();
    }
}
