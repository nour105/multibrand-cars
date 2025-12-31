<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Car;
use Illuminate\Http\Request;

class OfferController extends Controller
{
   public function index()
{
    $offers = Offer::with(['brands', 'cars'])->get();
    return response()->json([
        'success' => true,
        'data' => $offers,
    ]);
}


 public function store(Request $request)
{
    $validated = $request->validate([
    'title'       => 'required|string|max:255',
    'description' => 'nullable|string',
    'card_image'  => 'nullable|string',
    'banners'     => 'nullable|array',
    'start_date'  => 'required|date',
    'end_date'    => 'required|date|after:start_date',
    'car_ids'     => 'required|array',
    'car_ids.*'   => 'exists:cars,id',
]);


    // Create the offer without car_ids
    $offerData = $validated;
    unset($offerData['car_ids']); // remove car_ids from direct assignment
    $offer = Offer::create($offerData);

    // Sync cars separately
    $offer->cars()->sync($validated['car_ids']);

    return response()->json([
        'success' => true,
        'data' => $offer->load(['brands', 'cars']),
    ], 201);
}


public function show($id)
{
    $offer = Offer::with(['brands', 'cars'])->findOrFail($id);
    return response()->json([
        'success' => true,
        'data' => $offer,
    ]);
}

/**
 * Update the specified offer.
 */
   public function update(Request $request, $id)
{
    $offer = Offer::findOrFail($id);

    $validated = $request->validate([
        'brand_id'   => 'sometimes|exists:brands,id',
        'car_ids'    => 'sometimes|array',
        'car_ids.*'  => 'exists:cars,id',
        'title'      => 'sometimes|string|max:255',
        'description'=> 'nullable|string',
        'banners'    => 'nullable|array',
        'card_image' => 'nullable|string',
        'start_date' => 'sometimes|date',
        'end_date'   => 'sometimes|date|after:start_date',

    ]);

    $offerData = $validated;
    unset($offerData['car_ids']);
    $offer->update($offerData);

    if (isset($validated['car_ids'])) {
        $offer->cars()->sync($validated['car_ids']);
    }

    return response()->json([
        'success' => true,
        'data' => $offer->load(['brands', 'cars']),
    ]);
}


    /**
     * Delete the specified offer.
     */
    public function destroy($id)
    {
        try {
            $offer = Offer::find($id);
            
            if (!$offer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Offer not found',
                ], 404);
            }
            
            $offer->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Offer deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting offer',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function showBySlug(string $slug)
{
    $offer = Offer::with(['brands', 'cars'])
        ->where('slug', $slug)
        ->firstOrFail();

    return response()->json([
        'success' => true,
        'data' => $offer,
    ]);
}

}

