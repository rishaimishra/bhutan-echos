<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\TimelineEntryController;
use App\Http\Controllers\Api\EBookController;
use App\Http\Controllers\Api\AudioClipController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->get('/profile', [ProfileController::class, 'profile']);
Route::middleware('auth:sanctum')->put('/profile', [ProfileController::class, 'updateProfile']);

Route::get('/timeline-entries', [TimelineEntryController::class, 'index']);
Route::get('/ebooks', [EBookController::class, 'index']);
Route::get('/ebooks/{ebook}', [EBookController::class, 'show']);

Route::get('/audio-clips', [AudioClipController::class, 'index']);


