<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hotel_id',
        'city',
        'state',
        'country',
        'zip_code',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    /**
     * Get the hotel that owns the location.
     */
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class, 'foreign_key');
    }
}
