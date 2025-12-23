<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Car extends Model
{
    use HasFactory;

   protected $fillable = [
    'brand_id',
    'name',
    'slug', 
    'description',
    'content',
    'specifications',
    'interior_images',
    'exterior_images',
    'price',
    'currency',
    'emi_monthly',      
    'emi_months',       
    'available_trims',
    'colors',
    'features',
    'video_url',
    'banner_image',
];


   protected $casts = [
    'specifications' => 'array',
    'interior_images' => 'array',
    'exterior_images' => 'array',
    'available_trims' => 'array',
    'colors' => 'array',
    'features' => 'array',
];

// Accessors for image URLs
public function getInteriorImagesUrlAttribute()
{
    return $this->interior_images ? array_map(fn($i) => asset('storage/' . $i), $this->interior_images) : [];
}

protected static function booted()
{
    static::saving(function ($car) {
        if (empty($car->slug)) {
            $car->slug = Str::slug($car->name);
        }
    });
}

public function getExteriorImagesUrlAttribute()
{
    return $this->exterior_images ? array_map(fn($i) => asset('storage/' . $i), $this->exterior_images) : [];
}


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }


}
