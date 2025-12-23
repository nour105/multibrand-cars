<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of all cars.
     */
    public function index()
    {
        try {
            $cars = Car::with('brand')->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Cars retrieved successfully',
                'data' => $cars,
                'count' => $cars->count(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving cars',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display a specific car.
     */
   public function show($id)
{
    try {
        $car = Car::with('brand')->find($id);

        if (!$car) {
            return response()->json(['success' => false, 'message' => 'Car not found'], 404);
        }

        $carData = $car->toArray();
        $carData['interior_images'] = $car->interior_images_url;
        $carData['exterior_images'] = $car->exterior_images_url;

        return response()->json([
            'success' => true,
            'message' => 'Car retrieved successfully',
            'data' => $carData,
        ], 200);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Error retrieving car', 'error' => $e->getMessage()], 500);
    }
}


    /**
     * Store a newly created car.
     */
  public function store(Request $request)
{
    try {
     $validated = $request->validate([
    'brand_id' => 'required|exists:brands,id',
    'name' => 'required|string|max:255',
    'description' => 'nullable|string',
    'content' => 'nullable|string',
    'specifications' => 'nullable|array',
    'interior_images' => 'nullable|array',
    'exterior_images' => 'nullable|array',
    'emi_monthly' => 'nullable|numeric',
    'currency' => 'nullable|string|max:5',
    'available_trims' => 'nullable|array',
    'colors' => 'nullable|array',
    'features' => 'nullable|array',
    'video_url' => 'nullable|string',
]);

$car = Car::create($validated);

        $car->load('brand');

        return response()->json([
            'success' => true,
            'message' => 'Car created successfully',
            'data' => $car,
        ], 201);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $e->errors(),
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error creating car',
            'error' => $e->getMessage(),
        ], 500);
    }
}
 /**
     * Update the specified car.
     */
public function update(Request $request, $id)
{
    try {
        $car = Car::find($id);
        if (!$car) return response()->json(['success' => false, 'message' => 'Car not found'], 404);

        $validated = $request->validate([
            'brand_id' => 'sometimes|exists:brands,id',
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
              'price' => 'nullable|numeric',
    'emi_monthly' => 'nullable|numeric',
            'specifications' => 'nullable|array',
            'interior_images' => 'nullable|array',
            'exterior_images' => 'nullable|array',
        ]);

        $car->update($validated);
        $car->load('brand');

        return response()->json([
            'success' => true,
            'message' => 'Car updated successfully',
            'data' => $car,
        ], 200);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $e->errors(),
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error updating car',
            'error' => $e->getMessage(),
        ], 500);
    }
}

   


    /**
     * Delete the specified car.
     */
    public function destroy($id)
    {
        try {
            $car = Car::find($id);
            
            if (!$car) {
                return response()->json([
                    'success' => false,
                    'message' => 'Car not found',
                ], 404);
            }
            
            $car->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Car deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting car',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
public function showBySlug(string $slug)
{
    $car = Car::with('brand')
        ->where('slug', $slug)
        ->first();

    if (!$car) {
        return response()->json([
            'success' => false,
            'message' => 'Car not found',
        ], 404);
    }

    $carData = $car->toArray();
    $carData['interior_images'] = $car->interior_images_url;
    $carData['exterior_images'] = $car->exterior_images_url;

    return response()->json([
        'success' => true,
        'message' => 'Car retrieved successfully',
        'data' => $carData,
    ]);
}

    /**
     * Get cars by brand.
     */
    public function getByBrand($brandId)
    {
        try {
            $cars = Car::where('brand_id', $brandId)->with('brand')->get();
            
            if ($cars->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No cars found for this brand',
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Cars retrieved successfully',
                'data' => $cars,
                'count' => $cars->count(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving cars',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
