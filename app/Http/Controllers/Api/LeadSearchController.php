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
        try {
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
                'fetch_cars_only' => 'nullable|boolean',
            ]);

            $fetchCarsOnly = $data['fetch_cars_only'] ?? false;

            $emiBudget = 0;
            if (!empty($data['salary_range']) || !empty($data['visa_limit'])) {
                $emiBudget = $emiService->calculate(
                    $data['salary_range'] ?? null,
                    $data['has_loans'] ?? false,
                    $data['loan_type'] ?? null,
                    $data['visa_limit'] ?? null
                );
            }

            if (!$fetchCarsOnly) {
                Lead::create([
                    ...$data,
                    'emi_budget' => $emiBudget,
                    'emi_calculated' => true,
                ]);
            }

            $carsQuery = Car::with('brand');

            if ($emiBudget > 0) {
                $carsQuery->where('emi_monthly', '<=', $emiBudget);
            }

            $cars = $carsQuery->get()->map(fn ($car) => [
                'id' => $car->id,
                'name' => $car->name,
                'slug' => $car->slug,
                'brand' => $car->brand?->name,
                'price' => $car->price,
                'currency' => $car->currency,
                'emi_monthly' => $car->emi_monthly,

                // ✅ JSON data preserved
                'colors' => $car->colors ?? [],
                'features' => $car->features ?? [],
                'available_trims' => $car->available_trims ?? [],
'available_showrooms' => $car->available_showrooms ?? [],
'specifications' => $car->specifications ?? [],

                'image' => $car->banner_image
                    ? asset('storage/' . $car->banner_image)
                    : null,
            ]);

            return response()->json([
                'success' => true,
                'emi_budget' => $emiBudget,
                'results' => $cars,
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
