<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;
use App\Models\Location;

// Rute untuk tampilan utama
Route::get('/', function () {
    return view('welcome');
});

// Rute untuk tampilan peta
Route::get('/map', [LocationController::class, 'map'])->name('map.index');

// Rute resource untuk LocationController, dengan pengecualian rute index yang telah ada
Route::resource('locations', LocationController::class);

route::get ('/map_user', function (){
    $locations = Location::all();
    return view('map_user', compact('locations'));
});

