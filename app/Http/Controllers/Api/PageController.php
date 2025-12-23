<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of all pages.
     */
    public function index()
    {
        try {
            $pages = Page::with('parent', 'children')->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Pages retrieved successfully',
                'data' => $pages,
                'count' => $pages->count(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving pages',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display a specific page.
     */
    public function show($id)
    {
        try {
            $page = Page::with('parent', 'children')->find($id);
            
            if (!$page) {
                return response()->json([
                    'success' => false,
                    'message' => 'Page not found',
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Page retrieved successfully',
                'data' => $page,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving page',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created page.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:pages',
                'content' => 'nullable|string',
                'parent_id' => 'nullable|exists:pages,id',
                'is_published' => 'sometimes|boolean',
                'order' => 'sometimes|integer',
                'banners' => 'nullable|array',         // Accept multiple banners
    'banners.*' => 'string',  
            ]);
            
            $page = Page::create($validated);
            $page->load('parent', 'children');
            
            return response()->json([
                'success' => true,
                'message' => 'Page created successfully',
                'data' => $page,
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
                'message' => 'Error creating page',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified page.
     */
    public function update(Request $request, $id)
    {
        try {
            $page = Page::find($id);
            
            if (!$page) {
                return response()->json([
                    'success' => false,
                    'message' => 'Page not found',
                ], 404);
            }
            
            $validated = $request->validate([
                'title' => 'sometimes|string|max:255',
                'slug' => 'sometimes|string|max:255|unique:pages,slug,' . $id,
                'content' => 'nullable|string',
                'parent_id' => 'nullable|exists:pages,id',
                'is_published' => 'sometimes|boolean',
                'order' => 'sometimes|integer',
                'banners' => 'nullable|array',         // Accept multiple banners
    'banners.*' => 'string',  
            ]);
            
            $page->update($validated);
            $page->load('parent', 'children');
            
            return response()->json([
                'success' => true,
                'message' => 'Page updated successfully',
                'data' => $page,
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
                'message' => 'Error updating page',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete the specified page.
     */
    public function destroy($id)
    {
        try {
            $page = Page::find($id);
            
            if (!$page) {
                return response()->json([
                    'success' => false,
                    'message' => 'Page not found',
                ], 404);
            }
            
            $page->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Page deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting page',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get published pages.
     */
    public function getPublished()
    {
        try {
            $pages = Page::where('is_published', true)
                ->with('parent', 'children')
                ->orderBy('order')
                ->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Published pages retrieved successfully',
                'data' => $pages,
                'count' => $pages->count(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving published pages',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get page by slug.
     */
    public function getBySlug($slug)
    {
        try {
            $page = Page::where('slug', $slug)->with('parent', 'children')->first();
            
            if (!$page) {
                return response()->json([
                    'success' => false,
                    'message' => 'Page not found',
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Page retrieved successfully',
                'data' => $page,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving page',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
