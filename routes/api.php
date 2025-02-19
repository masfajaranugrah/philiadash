<?php

use App\Http\Controllers\Fitur\QuestionController;
use App\Http\Controllers\Fitur\WahanaController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
 use App\Http\Controllers\VisitorController;
use App\Http\Controllers\WhatController;

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
Route::get('/wahana',[WahanaController::class, 'index']);
Route::get('/question',[QuestionController::class, 'index']);

 Route::get('/whats', [WhatController::class, 'index']);
 Route::get('/telp', [UserController::class, 'telp']);


use App\Http\Controllers\EventController;

Route::apiResource('events', EventController::class);