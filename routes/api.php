<?php

use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\User\UserAuthController;
use App\Http\Controllers\User\UserController;
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

Route::group(['middleware' =>[ 'checkPassword' ,'changeLang'] ] ,function () {
    Route::get('login' , [UserAuthController::class,'login'])->name('login');
});

Route::group(['middleware' =>[ 'checkPassword' ,'changeLang','auth:api' ] ] ,function () {
    Route::apiResource('user' , UserController::class);
    Route::get('profile' , [UserController::class,'profile']);
    Route::put('profile/update' , [UserController::class,'profileUpdate']);
    Route::put('profile/password' , [UserController::class,'profilePassword']);

    Route::apiResource('role', RoleController::class);
});


