<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotel extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'rating',
        'reputation',
        'reputationBadge',
        'availability',
        'price',
        'image',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * @var string[]
     */
    protected $with = [
        'location'
    ];

    /**
     * Get the user for the hotels.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the attributes for the hotels.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the location associated with the hotel.
     */
    public function location()
    {
        return $this->hasOne(Location::class);
    }

    /**
     * Get the location associated with the hotel.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
