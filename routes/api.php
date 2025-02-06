<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
 use App\Http\Controllers\VisitorController;

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


 
Route::post('/track-visitor', [VisitorController::class, 'trackVisitor']);
Route::get('/visitor/device-counts', [VisitorController::class, 'getDeviceCounts']);


use App\Http\Controllers\EventController;

Route::apiResource('events', EventController::class);