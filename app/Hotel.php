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
        'category_id',
        'name',
        'rating',
        'reputation',
        'reputationBadge',
        'availability',
        'price',
        'image',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $with = [
        'location'
    ];

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

}
