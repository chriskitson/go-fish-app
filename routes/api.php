<?php

use App\Http\Controllers\VenueController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\BootstrapController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register', [RegisterController::class, 'register']);
Route::get('load', [BootstrapController::class, 'load']);

// venues
Route::get('venues', [VenueController::class, 'all']);
Route::get('venues/{id}', [VenueController::class, 'all']);
Route::get('venues/tickets/{id}', [VenueController::class, 'tickets']);
Route::get('venues/ticket/{venue}/{id}', [VenueController::class, 'ticket']);




// search
Route::get('search/{date}/{location}', [VenueController::class, 'search']);




Route::get('auth/venues/tickets/{id}', [VenueController::class, 'tickets'])->middleware('auth:api');
Route::get('auth/venues/ticket/{venue}/{id}', [VenueController::class, 'ticket'])->middleware('auth:api');
Route::get('auth/logout', [UserController::class, 'logout'])->middleware('auth:api');


Route::get('auth/basket', [BasketController::class, 'get'])->middleware('auth:api');
Route::post('auth/basket/{venue_id}/{ticket_id}/{date}', [BasketController::class, 'add'])->middleware('auth:api');
Route::get('auth/basket/{id}/up', [BasketController::class, 'basket_increase'])->middleware('auth:api');
Route::get('auth/basket/{id}/down', [BasketController::class, 'basket_decrease'])->middleware('auth:api');
Route::delete('auth/basket/{id}', [BasketController::class, 'basket_remove'])->middleware('auth:api');

Route::post('auth/book', [BookingController::class, 'book'])->middleware('auth:api');



// booking confirmation
Route::post('book/confirm', [BookingController::class, 'confirm']);