<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'biography',
        'banners',
    ];

    protected $casts = [
        'banners' => 'array',
    ];

    protected static function booted()
    {
        static::creating(function ($brand) {
            if (empty($brand->slug)) {
                $brand->slug = Str::slug($brand->name);
            }
        });

        static::updating(function ($brand) {
            if ($brand->isDirty('name')) {
                $brand->slug = Str::slug($brand->name);
            }
        });
    }

    // Full URLs (optional but recommended)
    protected $appends = ['logo_url', 'banners_url'];

    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }

    public function getBannersUrlAttribute()
    {
        return $this->banners
            ? array_map(fn ($b) => asset('storage/' . $b), $this->banners)
            : [];
    }
    public function offers()
{
    return $this->belongsToMany(Offer::class);
}

}

