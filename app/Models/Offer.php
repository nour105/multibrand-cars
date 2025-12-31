<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Offer extends Model
{
  protected $fillable = [
    'title',
    'slug',
    'description',
    'price',
    'currency',
    'banners',
    'card_image',
    'start_date',
    'end_date',
];


    protected $casts = [
        'banners' => 'array',
    ];

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'offer_brand');
    }

 public function cars()
    {
        return $this->belongsToMany(Car::class, 'car_offer', 'offer_id', 'car_id');
    }
}

