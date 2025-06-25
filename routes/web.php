<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThingSpeakController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/lihat-data', [ThingSpeakController::class, 'readData']);
Route::get('/api/data-thingspeak', [ThingSpeakController::class, 'getJsonData']);

