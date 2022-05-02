<?php

use App\Http\Controllers\VenueController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\BootstrapController;
use App\Http\Controllers\WebhookController;
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

/*
PUBLIC ENDPOINTS
*/

// login and registration
Route::post('register', [RegisterController::class, 'register']);
Route::post('signup', [RegisterController::class, 'signup']);
Route::get('signup/{id}', [RegisterController::class, 'get_subscription']);

Route::get('load', [BootstrapController::class, 'load']);
Route::get('user', [BootstrapController::class, 'user']);

// venues (no user context)
Route::get('venues', [VenueController::class, 'all']);
Route::get('venues/near', [VenueController::class, 'near']);
Route::get('venues/{id}', [VenueController::class, 'all']);
Route::get('venues/tickets/{id}', [VenueController::class, 'tickets']);
Route::get('venues/ticket/{venue}/{id}', [VenueController::class, 'ticket']);

// search
Route::get('search/{date}/{location}', [VenueController::class, 'search']);

// booking confirmation (from Stripe)
Route::post('hook/direct', [WebhookController::class, 'direct']);
Route::post('hook/connect', [WebhookController::class, 'connect']);

/*
PROTECTED ENDPOINTS
*/
Route::group([
    'middleware' => ['auth:api']
], function () {

    // user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('auth/logout', [UserController::class, 'logout']);

    // venues (with user context)
    Route::get('auth/venues/tickets/{id}', [VenueController::class, 'tickets']);
    Route::get('auth/venues/ticket/{venue}/{id}', [VenueController::class, 'ticket']);
    Route::get('auth/venues/get', [VenueController::class, 'all']);
    Route::get('auth/venues/near', [VenueController::class, 'near']);

    // basket
    Route::get('auth/basket', [BasketController::class, 'get']);
    Route::post('auth/basket/{venue_id}/{ticket_id}/{date}', [BasketController::class, 'add']);
    Route::get('auth/basket/{id}/up', [BasketController::class, 'basket_increase']);
    Route::get('auth/basket/{id}/down', [BasketController::class, 'basket_decrease']);
    Route::delete('auth/basket/{id}', [BasketController::class, 'basket_remove']);

    // booking
    Route::post('auth/book', [BookingController::class, 'book']);

    // user tickets
    Route::get('auth/bookings/user', [BookingController::class, 'user']);
    Route::get('auth/booking/{id}', [BookingController::class, 'get']);

    // venue bookings
    Route::get('auth/bookings/venue', [BookingController::class, 'venue']);

    // load (with user context)
    Route::get('auth/load', [BootstrapController::class, 'load']);
    Route::get('auth/user', [BootstrapController::class, 'user']);

    // cache buster
    Route::get('auth/cache/bust', [BootstrapController::class, 'cache_bust']);

    // manage venues
    Route::post('auth/venues', [VenueController::class, 'create_venue']);
    Route::put('auth/venues/{id}/details', [VenueController::class, 'manage_details']);
    Route::put('auth/venues/{id}/ticket', [VenueController::class, 'manage_ticket']);
    Route::delete('auth/venues/{venue_id}/ticket/{id}', [VenueController::class, 'delete_ticket']);
    Route::post('auth/venues/{id}/image', [VenueController::class, 'upload_image']);
    Route::delete('auth/venues/{id}/image', [VenueController::class, 'delete_image']);
    Route::delete('auth/venues/{id}', [VenueController::class, 'delete']);
    Route::post('auth/venues/{id}/closed', [VenueController::class, 'closed_add']);
    Route::delete('auth/venues/{venue_id}/closed/{id}', [VenueController::class, 'closed_delete']);
    Route::get('auth/venues/{id}/subscription', [VenueController::class, 'subscription_create']);
    Route::delete('auth/venues/{id}/subscription', [VenueController::class, 'subscription_cancel']);
});
