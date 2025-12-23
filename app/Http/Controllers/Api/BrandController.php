<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of all brands.
     */
    public function index()
    {
        try {
            $brands = Brand::all();
            
            return response()->json([
                'success' => true,
                'message' => 'Brands retrieved successfully',
                'data' => $brands,
                'count' => $brands->count(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving brands',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display a specific brand.
     */
    public function show($id)
    {
        try {
            $brand = Brand::find($id);
            
            if (!$brand) {
                return response()->json([
                    'success' => false,
                    'message' => 'Brand not found',
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Brand retrieved successfully',
                'data' => $brand,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving brand',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created brand.
     */
    public function store(Request $request)
    {
        try {
           $validated = $request->validate([
    'name' => 'required|string|max:255|unique:brands',
        'slug' => 'nullable|string|unique:brands,slug',

    'logo' => 'nullable|string',
    'biography' => 'nullable|string',
    'banners' => 'nullable|array',
]);

            
            $brand = Brand::create($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Brand created successfully',
                'data' => $brand,
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
                'message' => 'Error creating brand',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified brand.
     */
    public function update(Request $request, $id)
    {
        try {
            $brand = Brand::find($id);
            
            if (!$brand) {
                return response()->json([
                    'success' => false,
                    'message' => 'Brand not found',
                ], 404);
            }
            
           $validated = $request->validate([
    'name' => 'sometimes|string|max:255|unique:brands,name,' . $id,
        'slug' => 'sometimes|string|unique:brands,slug,' . $id,
    'logo' => 'nullable|string',
    'biography' => 'nullable|string',
    'banners' => 'nullable|array',
]);

            
            $brand->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Brand updated successfully',
                'data' => $brand,
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
                'message' => 'Error updating brand',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete the specified brand.
     */
    public function destroy($id)
    {
        try {
            $brand = Brand::find($id);
            
            if (!$brand) {
                return response()->json([
                    'success' => false,
                    'message' => 'Brand not found',
                ], 404);
            }
            
            $brand->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Brand deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting brand',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
