<?php

use App\Http\Controllers\Fitur\CalendarEventController;
use App\Http\Controllers\Fitur\QuestionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Fitur\WahanaController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'dash'])->name('dash');

Route::get('wahana-view',[WahanaController::class, 'view'])->name('wahana');
Route::post('wahana-create',[WahanaController::class, 'store'])->name('create');
Route::patch('wahana-update/{id_wahana}',[WahanaController::class, 'update'])->name('update');
Route::delete('wahana-delete/{id_wahana}',[WahanaController::class, 'destroy'])->name('delete');




Route::get('question',[QuestionController::class, 'view'])->name('question');
Route::post('question-create',[QuestionController::class, 'store'])->name('create-question');
Route::patch('question-update/{id_question}',[QuestionController::class, 'update'])->name('update-question');
Route::delete('question-delete/{id_question}',[QuestionController::class, 'destroy'])->name('delete-question');



use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WhatController;

Route::post('events', [EventController::class, 'store']);
Route::get('events', [EventController::class, 'index']);
Route::get('events-view', [EventController::class, 'view'])->name('event');
Route::put('events/{id}', [EventController::class, 'update']);
Route::delete('events/{id}', [EventController::class, 'destroy']);


Route::get('user', [UserController::class, 'view'])->name('user');
Route::get('user-setting', [UserController::class, 'index'])->name('user-setting');
Route::post('profile-post', [UserController::class, 'store'])->name('profile-post');
Route::patch('profile/update/{id}', [UserController::class, 'update'])->name('profile.update');
Route::patch('reset/{id}', [UserController::class, 'updatePassword'])->name('reset');

Route::get('/whats-view', [WhatController::class, 'view'])->name('whats');
Route::post('/whats-create', [WhatController::class, 'store'])->name('whats.create');
Route::delete('/whats-delete/{id_whats}', [WhatController::class, 'destroy'])->name('whats.delete');
Route::patch('/whats-edit/{id_whats}', [WhatController::class, 'update'])->name('whats.update');



Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
 