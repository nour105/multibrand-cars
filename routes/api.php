<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\LeadSearchController;
use App\Http\Controllers\Api\MarketingLeadController;
use App\Http\Controllers\Api\CallbackRequestController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public API Routes (No Authentication Required)
Route::prefix('v1')->group(function () {
    
    // Offers Routes
    Route::prefix('offers')->group(function () {
        Route::get('/', [OfferController::class, 'index']);
        Route::get('/slug/{slug}', [OfferController::class, 'showBySlug']);
        Route::get('/{id}', [OfferController::class, 'show']);
        Route::post('/', [OfferController::class, 'store']);
        Route::put('/{id}', [OfferController::class, 'update']);
        Route::delete('/{id}', [OfferController::class, 'destroy']);

    });

    // Brands Routes
    Route::prefix('brands')->group(function () {
        Route::get('/', [BrandController::class, 'index']);
        Route::get('/{id}', [BrandController::class, 'show']);
        Route::get('/brands/slug/{slug}', [BrandController::class, 'showBySlug']);
        Route::post('/', [BrandController::class, 'store']);
        Route::put('/{id}', [BrandController::class, 'update']);
        Route::delete('/{id}', [BrandController::class, 'destroy']);
    });

    // Cars Routes
    Route::prefix('cars')->group(function () {
        Route::get('/', [CarController::class, 'index']);
        Route::get('/{id}', [CarController::class, 'show']);
        Route::get('/slug/{slug}', [CarController::class, 'showBySlug']);
        Route::post('/', [CarController::class, 'store']);
        Route::put('/{id}', [CarController::class, 'update']);
        Route::delete('/{id}', [CarController::class, 'destroy']);
        Route::get('/brand/{brandId}', [CarController::class, 'getByBrand']);
    });



    // Pages Routes
    Route::prefix('pages')->group(function () {
        Route::get('/', [PageController::class, 'index']);
        Route::get('/{id}', [PageController::class, 'show']);
        Route::post('/', [PageController::class, 'store']);
        Route::put('/{id}', [PageController::class, 'update']);
        Route::delete('/{id}', [PageController::class, 'destroy']);
        Route::get('/published/list', [PageController::class, 'getPublished']);
        Route::get('/slug/{slug}', [PageController::class, 'getBySlug']);
    });
Route::post('/lead-search', [LeadSearchController::class, 'store']);
Route::post('/leads', [LeadSearchController::class, 'store']);

Route::post('/marketing-leads', [MarketingLeadController::class, 'store']);
    Route::post('/callback-requests', [CallbackRequestController::class, 'store']);

});
