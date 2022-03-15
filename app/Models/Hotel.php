<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

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
}
