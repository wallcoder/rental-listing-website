<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SaveController;
use App\Http\Middleware\JwtAuthenticate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, "register"]);
Route::post('/login', [AuthController::class, "login"]);
Route::get('/test', function(Request $request){
    $user = $request->user();
    return response()->json(['message'=>'Success', 'data'=>$user]);
})->middleware(JwtAuthenticate::class);

Route::middleware(JwtAuthenticate::class)->group(function(){
    Route::get('/me', [AuthController::class, 'checkToken']);
    Route::put('/user/edit-name', [AuthController::class, 'editName']);
    Route::delete('/user/delete-account', [AuthController::class, 'deleteAccount']);
    Route::put('/user/change-password', [AuthController::class, 'changePassword']);
    Route::post('/post/create', [PostController::class, 'store']);
    Route::post('/save/create/{id}', [SaveController::class, 'store']);
    Route::get('/saves', [SaveController::class, 'index']);

});
Route::get('/posts', [PostController::class, "index"]);
Route::get('/item/{slug}', [PostController::class, "show"]);
Route::get('/browse', [PostController::class, "browse"]);
Route::post('/logout', [AuthController::class, "logout"]);