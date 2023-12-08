<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {

    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('refresh', [\App\Http\Controllers\AuthController::class, 'refresh']);
    Route::post('me',  [\App\Http\Controllers\AuthController::class, 'me']);

    Route::group(['middleware' => 'jwt.auth'], function (){
        Route::get('/users', [\App\Http\Controllers\User\StoreController::class, 'index'])->name('users.index');
        Route::post('/users/add', [\App\Http\Controllers\User\StoreController::class, 'add'])->name('users.add');
        Route::get('/users/friends', [\App\Http\Controllers\User\StoreController::class, 'friendsItems'])->name('users.friends');
    });
});

Route::group(['namespace' => 'User', 'prefix' => 'users'], function (){
    Route::post('/', [\App\Http\Controllers\User\StoreController::class, '__invoke'])->name('users.invoke');
});
