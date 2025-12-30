<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Lead;
use App\Services\EmiCalculatorService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LeadSearchController extends Controller
{
    public function store(Request $request, EmiCalculatorService $emiService)
{
    $data = $request->validate([
        'name' => 'required|string',
        'phone' => 'required|string',
        'email' => 'required|email',

        'salary_range' => 'nullable|string',
        'has_loans' => 'nullable|boolean',
        'loan_type' => 'nullable|string',
        'visa_limit' => 'nullable|string',
        'bank' => 'nullable|string',

        'purchase_timeline' => 'nullable|string',
        'car_id' => 'nullable|exists:cars,id',

        'marketing_consent' => 'nullable|boolean',
        'privacy_accepted' => 'required|boolean',
        'fetch_cars_only' => 'nullable|boolean', // ✅ Flag جديد
    ]);

    $fetchCarsOnly = $data['fetch_cars_only'] ?? false;

    // 👉 EMI decision
    $canCalculateEmi =
        !empty($data['salary_range']) ||
        !empty($data['visa_limit']) ||
        !empty($data['bank']);

    $emiBudget = 0;

    if ($canCalculateEmi) {
        $emiBudget = $emiService->calculate(
            $data['salary_range'] ?? null,
            $data['has_loans'] ?? 0,
            $data['loan_type'] ?? null,
            $data['visa_limit'] ?? null
        );
    }

    // ⚠️ فقط إذا ما كان طلب Show Cars فقط نخزن Lead
    if (!$fetchCarsOnly) {
        Lead::create([
            ...$data,
            'emi_budget' => $emiBudget,
            'emi_calculated' => $canCalculateEmi,
        ]);
    }

    // 👉 Cars query
    $now = Carbon::now();

    $carsQuery = Car::with([
        'brand',
        'offers' => fn ($q) =>
            $q->whereDate('start_date', '<=', $now)
              ->whereDate('end_date', '>=', $now),
    ]);

    if ($canCalculateEmi && $emiBudget > 0) {
        $carsQuery->where('emi_monthly', '<=', $emiBudget);
    }

    $cars = $carsQuery->get()->map(fn ($car) => [
        'id' => $car->id,
        'name' => $car->name,
        'brand' => $car->brand?->name,
        'price' => $car->price,
        'currency' => $car->currency,
        'emi_monthly' => $car->emi_monthly,
        'has_offer' => $car->offers->isNotEmpty(),
        'image' => $car->banner_image
            ? asset('storage/' . $car->banner_image)
            : 'https://via.placeholder.com/400x250',
    ]);

    return response()->json([
        'success' => true,
        'emi_budget' => $emiBudget,
        'results' => $cars,
    ]);
}

}
