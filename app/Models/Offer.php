<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Offer extends Model
{
    protected $fillable = [
        'brand_id',
        'title',
        'slug',
        'description',
        'banners',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'banners' => 'array',
    ];

    /**
     * Auto-generate slug from title
     */
    protected static function booted()
    {
        static::creating(function ($offer) {
            if (empty($offer->slug)) {
                $offer->slug = Str::slug($offer->title);
            }
        });

        static::updating(function ($offer) {
            if ($offer->isDirty('title')) {
                $offer->slug = Str::slug($offer->title);
            }
        });
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'offer_brand');
    }

    public function cars()
    {
        return $this->belongsToMany(Car::class, 'offer_car');
    }

    // Sync cars when saving
    public function setCarIdsAttribute($value)
    {
        $this->cars()->sync($value ?? []);
    }
}
