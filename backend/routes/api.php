<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\JwtAuthenticate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, "register"]);
Route::post('/login', [AuthController::class, "login"]);
Route::get('/test', function(){
    return response()->json(['message'=>'Success']);
})->middleware(JwtAuthenticate::class);

Route::middleware(JwtAuthenticate::class)->group(function(){
    Route::get('/me', [AuthController::class, 'checkToken']);

});

Route::post('/logout', [AuthController::class, "logout"]);