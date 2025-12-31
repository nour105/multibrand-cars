<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CallbackRequest;   // ✅ هذا السطر المهم
use Illuminate\Http\Request;

class CallbackRequestController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'phone'  => 'required|string|max:30',
            'reason' => 'required|string|max:255',
        ]);

        CallbackRequest::create($data);

        return response()->json([
            'status' => 'ok',
            'message' => 'Callback request submitted successfully',
        ]);
    }
}
