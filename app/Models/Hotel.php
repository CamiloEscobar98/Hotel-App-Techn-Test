<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

use App\Models\Room;
use App\Models\Localization\City;

class Hotel extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hotels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nit', 'name', 'address', 'properties', 'city_id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'properties' => 'json',
    ];

    /**
     * Set the Hotel's name.
     *
     * @param  string  $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        return $this->attributes['name'] = Str::lower($value);
    }

    /**
     * Get the Hotel's name.
     *
     * @param  string  $value
     * @return string
     */
    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * Set the Hotel's address.
     *
     * @param  string  $value
     * @return void
     */
    public function setAddressAttribute($value)
    {
        return $this->attributes['address'] = Str::lower($value);
    }

    /**
     * Get the Hotel's address.
     *
     * @param  string  $value
     * @return string
     */
    public function getAddressAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * Set the Hotel's properties.
     *
     * @param  string  $value
     * @return void
     */
    public function setPropertiesAttribute($value)
    {
        return $this->attributes['properties'] = json_encode($value);
    }

    /**
     * Get the Hotel's properties.
     *
     * @param  string  $value
     * @return string
     */
    public function getPropertiesAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Get the listing of Room which is relationed with Hotel.
     * 
     * @return Room[] $rooms
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Get the City which is relationd with Hotel.
     * 
     * @return City $city
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the number of rooms which the Hotel has.
     * 
     * @return int $numberOfRooms
     */
    public function numberOfRooms()
    {
        return $this->rooms->sum('ammount_rooms');
    }

    /**
     * Get the number of rooms which the model has and the assignment_type_id is $id.
     * 
     * @param $assignmentTypeId;
     * @return int $numberOfRooms
     */
    public function numberOfRoomsWhenNotAssignmentType($assignmentTypeId)
    {
        return $this->rooms->whereNot('assignment_room_id', $assignmentTypeId)->sum('ammount_rooms');
    }
}
