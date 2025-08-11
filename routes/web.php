<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnquiryController;

// home
Route::get('/', function () {
    return view('welcome');
});

// enq creation interface
Route::get('/create-enq-form', function () {
    return view('customer.create-enq');
});

// quotation search (public) interface
Route::get('/search-quotation', function () {
    return view('customer.search-quotations');
});

// create enq
Route::post('/api/enquiries', [EnquiryController::class, 'store'])->name('enquiries.store');

// dashboard - uses token auth, therefore no need to protect within sanctum
Route::get('/my-dashboard', function () {
    return view('my-dashboard');
});

// ** 
//    sanctum protected routes **
// ** 

Route::middleware([

    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',

])->group(function () {

    

});
