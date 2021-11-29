<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/login', function () {
    return view('index');
})->name('login');

Route::get('/venue/{venueid}', function ($venueid) {
    return view('index', ['venueid' => $venueid]);
});

Route::get('/basket', function () {
    return view('index');
});

Route::get('/search/{date}/{location}', function ($date, $location) {
    return view('index', ['date' => $date, 'location' => $location]);
});

Route::get('/confirm/{session}', function ($session) {
    return view('index', ['confirmid' => $session]);
});

Route::get('/tickets', function () {
    return view('index');
});

Route::get('/manage-venues', function () {
    return view('index');
});

Route::get('/manage-venues/{id}', function ($id) {
    return view('index', ['venuemanageid' => $id]);
});

Route::get('/add-venue', function () {
    return view('index');
});

Route::get('/category/{categoryid}', function ($categoryid) {
    return view('index', ['categoryid' => $categoryid]);
});