<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;


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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class,'login']);
    Route::post('signup', [AuthController::class,'signup']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);

});

Route::group([

    'middleware' => 'auth:api',
    'prefix' => 'product'

], function ($router) {

    Route::post('/', [ProductController::class,'store']);
    Route::get('/', [ProductController::class,'index']);
    Route::put('/{id}', [ProductController::class,'update'])->where('id', '[0-9]+');
    Route::delete('/{id}', [ProductController::class,'destroy'])->where('id', '[0-9]+');

});

Route::group([

    'middleware' => 'auth:api',
    'prefix' => 'admin'

], function ($router) {

    Route::get('/users', [AdminController::class,'users']);

});
