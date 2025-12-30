<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketingLead extends Model
{
    protected $fillable = [
        // User
        'name',
        'email',
        'phone',

        // Finance
        'salary',
        'bank',

        // Source
        'source_type',
        'source_id',

        // Meta
        'car_name',
        'offer_title',
        'price',
        'currency',

        // UTM
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
    ];
}
