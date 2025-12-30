<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MarketingLead; 

class MarketingLeadController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'nullable|email',

            'salary' => 'nullable|numeric',
            'bank' => 'nullable|string',

            'source_type' => 'required|in:car,offer',
            'source_id' => 'nullable|integer',

            'car_name' => 'nullable|string',
            'offer_title' => 'nullable|string',
            'price' => 'nullable|string',
            'currency' => 'nullable|string',

            'utm_source' => 'nullable',
            'utm_medium' => 'nullable',
            'utm_campaign' => 'nullable',
            'utm_term' => 'nullable',
            'utm_content' => 'nullable',
        ]);

        MarketingLead::create($data);

        return response()->json(['success' => true]);
    }
}
