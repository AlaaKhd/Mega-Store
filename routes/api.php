<?php

use App\Http\Controllers\authcontroller;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::prefix("auth")->group(function() {
    Route::post('sign_up', [\App\Http\Controllers\authcontroller::class, 'createaccount']);
    Route::post('login', [\App\Http\Controllers\authcontroller::class, 'login']);

    Route::middleware(['auth:api'])->group(function() {
    Route::get('logout', [authcontroller::class, 'logout']);
});

});

/*

                product  routes
*/


Route::prefix("products")->group(function() {
    Route::get('index', [ProductController::class, 'index']);
    Route::get('show/{product}', [\App\Http\Controllers\ProductController::class, 'show']);
    Route::post('search', [\App\Http\Controllers\ProductController::class, 'search']);


});


Route::middleware(['auth:api'])->group(function() {


Route::prefix("products")->group(function() {

//    Route::get('/', [\App\Http\Controllers\ProductController::class, 'index']);
    Route::post('store', [\App\Http\Controllers\ProductController::class, 'store']);
//    Route::get('/{product}', [\App\Http\Controllers\ProductController::class, 'show']);
    Route::put('update/{product}', [\App\Http\Controllers\ProductController::class, 'update']);
    Route::delete('destroy/{product}', [\App\Http\Controllers\ProductController::class, 'destroy']);

    Route::prefix("/{product}/comments")->group(function (){
        Route::get('index', [\App\Http\Controllers\CommentController::class, 'index']);
        Route::post('store', [\App\Http\Controllers\CommentController::class, 'store']);
        //Route::put('update/{comment}', [\App\Http\Controllers\CommentController::class, 'update']);
        //Route::delete('destroy/{comment}', [\App\Http\Controllers\CommentController::class, 'destroy']);
    });

    Route::post('like', [\App\Http\Controllers\LikeController::class, 'store']);
   // Route::post('comment', [\App\Http\Controllers\CommentController::class, 'store']);

});
});


Route::prefix("categories")->group(function() {
    Route::get('index', [\App\Http\Controllers\CategController::class, 'index']);
    Route::get('show/{categ}', [\App\Http\Controllers\CategController::class, 'show']);
});


    Route::middleware(['auth:api'])->group(function() {

Route::prefix("categories")->group(function(){
    Route::post('store', [\App\Http\Controllers\CategController::class, 'store']);
    Route::put('update/{categ}', [\App\Http\Controllers\CategController::class, 'update']);
    Route::delete('destroy/{categ}', [\App\Http\Controllers\CategController::class, 'destroy']);


});
});
