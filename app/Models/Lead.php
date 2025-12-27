<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'salary_range',
        'bank',
        'loan_type',
        'visa_limit',
        'purchase_timeline',
        'marketing_consent',
        'privacy_accepted',
        'emi_budget',
    ];
}
