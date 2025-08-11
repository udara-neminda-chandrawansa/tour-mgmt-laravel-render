<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\API\ItineraryController;
use App\Http\Controllers\API\QuotationController;
use App\Http\Controllers\API\PaymentController;
use App\Models\User;

// auth routes (they use 'auth' as prefix - ex: api/auth/login, api/auth/register, api/auth/logout)
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});

// View specific quotation - public
Route::get('/quotations/public/{uniqueId}', [QuotationController::class, 'publicShow']);

// ** 
//    sanctum protected routes **
// ** 

// return enquiries
Route::middleware('auth:sanctum')->get('/enquiries', [EnquiryController::class, 'index']);

// return user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//return all users
Route::middleware('auth:sanctum')->get('/users', function () {
    return response()->json([
        'users' => User::all()
    ]);
});

// update enquiry status
Route::middleware('auth:sanctum')->patch('/enquiries/{id}/status', [EnquiryController::class, 'updateStatus']);

// assign enquiry to agent
Route::middleware('auth:sanctum')->put('/enquiries/{id}/assign', [EnquiryController::class, 'assignAgent']);

// itinerary mgmt routes
Route::middleware('auth:sanctum')->group(function () {
    // create itinerary - Agent
    Route::post('/itineraries', [ItineraryController::class, 'store']);

    // List itineraries (paginated) - Agent (if assigned) or Admin
    Route::get('/itineraries', [ItineraryController::class, 'index']);

    // View specific itinerary - Agent (if assigned) or Admin
    Route::get('/itineraries/{id}', [ItineraryController::class, 'show']);

    // Update itinerary - Agent (if assigned) or Admin
    Route::put('/itineraries/{id}', [ItineraryController::class, 'update']);

    // Delete itinerary (soft delete) - Agent (if assigned) or Admin
    Route::delete('/itineraries/{id}', [ItineraryController::class, 'destroy']);
});

// quotation mgmt routes
Route::middleware('auth:sanctum')->group(function () {
    // create quotation - Agent
    Route::post('/quotations', [QuotationController::class, 'store']);

    // List itineraries - Agent (if assigned) or Admin
    Route::get('/quotations', [QuotationController::class, 'index']);

    // View specific quotation - Agent (if assigned) or Admin
    Route::get('/quotations/{id}', [QuotationController::class, 'show']);
});

// payment mgmt routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/payments', [PaymentController::class, 'index']);
    Route::post('/payments', [PaymentController::class, 'store']);
});