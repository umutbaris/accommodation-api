<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
        'reputation_badge',
        'availability',
        'price',
        'image',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'user_id',
        'category_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    /**
     * @var string[]
     */
    protected $appends = [
        'category'
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
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the attributes for the hotels.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the location associated with the hotel.
     */
    public function location(): HasOne
    {
        return $this->hasOne(Location::class);
    }

    /**
     * Get the location associated with the hotel.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function getCategoryAttribute(): string
    {
        $category = $this->category()->get()->first()->name;

        return $category;
    }
}
