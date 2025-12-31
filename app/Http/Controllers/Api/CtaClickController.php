<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CtaClick;
use Illuminate\Http\Request;

class CtaClickController extends Controller
{
    public function store(Request $request)
    {
        CtaClick::create([
            'cta'      => $request->cta,
            'car_id'   => $request->car_id,
            'car_name' => $request->car_name,
        ]);

        return response()->json(['ok' => true]);
    }
}
