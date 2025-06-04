<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\SaveController;
use App\Http\Middleware\AuthPlan;
use App\Http\Middleware\CheckMerchant;
use App\Http\Middleware\JwtAuthenticate;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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
    Route::delete('/post/delete/{id}', [PostController::class, 'destroy']);
    Route::put('/post/boost/{id}', [PostController::class, 'setBoost']);
    Route::put('/user/change-password', [AuthController::class, 'changePassword']);
    Route::put('/plan/subscribe/{id}', [PlanController::class, 'update']);
    // Route::post('/post/create', [PostController::class, 'store']);
    Route::middleware(CheckMerchant::class)->post('/post/create', [PostController::class, 'store']);
    Route::post('/post/mark-rent/{id}', [PostController::class, 'markRented']);
    Route::post('/save/create/{id}', [SaveController::class, 'store']);
    Route::get('/saves', [SaveController::class, 'index']);
    Route::get('/saves/listings', [SaveController::class, 'getSavedListings']);
    Route::get('/user/posts', [PostController::class, 'getUserPosts']);
    Route::post('/create-order', [PaymentController::class, 'createOrder']);
    Route::post('/booking/create-order', [BookingController::class, 'createOrder']);
    Route::post('/booking/verify-payment', [BookingController::class, 'verifyPayment']);
    Route::post('/verify-payment', [PaymentController::class, 'verifyPayment']);
    Route::post('/store-payment', [PaymentController::class, 'storePayment']);
    Route::post('/store-failed-payment', [RazorpayController::class, 'storeFailed']);
    Route::get('/user/payments', [PaymentController::class, 'getUserPayments']);
    Route::get('/user/plans', [PlanController::class, 'show']);
    Route::post('/user/kyc', [PaymentController::class, 'registerSubMerchant']);
    Route::get('/checkout-info/{slug}', [BookingController::class, 'getCheckoutInfo']);
    Route::post('/booking/insert', [BookingController::class, 'insertBooking']);
    Route::get('/check-booking', [BookingController::class, 'checkBookingConflict']);
    Route::post('/booking/store-payment', [BookingController::class, 'storePayment']);
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'handler'] )->middleware([ 'signed'])->name('verification.verify');
    
   
});
Route::get('/posts', [PostController::class, "index"]);
Route::get('/top-locations', [PostController::class, "getTopLocations"]);
Route::get('/plans', [PlanController::class, "index"]);
Route::get('/item/{slug}', [PostController::class, "show"]);
Route::get('/browse', [PostController::class, "browse"]);
Route::post('/logout', [AuthController::class, "logout"]);