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

Route::get('/confirm', function () {
    return view('index');
});

Route::get('/tickets', function () {
    return view('index');
});