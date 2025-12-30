<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',

        'salary_range',
        'has_loans',
        'loan_type',
        'visa_limit',
        'bank',

        'emi_budget',
        'emi_calculated',

        'car_id',
        'purchase_timeline',

        'marketing_consent',
        'privacy_accepted',
    ];

    protected $casts = [
        'has_loans' => 'boolean',
        'marketing_consent' => 'boolean',
        'privacy_accepted' => 'boolean',
        'emi_calculated' => 'boolean',
        'emi_budget' => 'integer',
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
