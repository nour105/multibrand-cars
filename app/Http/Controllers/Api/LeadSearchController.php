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

            'salary_range' => 'nullable|string',
            'has_loans' => 'nullable|boolean',
            'bank' => 'nullable|string',
            'loan_type' => 'nullable|string',
            'visa_limit' => 'nullable|string',
            'purchase_timeline' => 'nullable|string',

            'marketing_consent' => 'nullable|boolean',
            'privacy_accepted' => 'required|boolean',
        ]);

        // 1️⃣ Calculate EMI
        $emiBudget = $emiService->calculate(
            $data['salary_range'] ?? null,
            $data['has_loans'] ?? 0,
            $data['loan_type'] ?? null,
            $data['visa_limit'] ?? null
        );

        // 2️⃣ Save Lead
        $lead = Lead::create([
            ...$data,
            'emi_budget' => $emiBudget,
        ]);

        $now = Carbon::now();

        // 3️⃣ Cars Query (with Offers)
        $carsQuery = Car::query()
            ->with([
                'brand',
                'offers' => function ($q) use ($now) {
                    $q->whereDate('start_date', '<=', $now)
                      ->whereDate('end_date', '>=', $now);
                }
            ]);

        if ($emiBudget > 0) {
            $carsQuery->where('emi_monthly', '<=', $emiBudget);
        }

        // 4️⃣ Format Response
        $cars = $carsQuery->get()
            ->map(fn ($car) => [
                'id' => $car->id,
                'name' => $car->name,
                'brand' => $car->brand?->name,
                'price' => $car->price,
                'currency' => $car->currency,
                'emi_monthly' => $car->emi_monthly,

                'has_offer' => $car->offers->isNotEmpty(),

                'offers' => $car->offers->map(fn ($offer) => [
                    'id' => $offer->id,
                    'title' => $offer->title,
                    'slug' => $offer->slug,
                    'banners' => $offer->banners,
                ]),

                'image' => $car->banner_image
                    ? asset('storage/' . $car->banner_image)
                    : 'https://via.placeholder.com/400x250',
            ])
            ->sortByDesc('has_offer') // offers first
            ->values();

        return response()->json([
            'success' => true,
            'emi_budget' => $emiBudget,
            'results' => $cars,
        ]);
    }
}
