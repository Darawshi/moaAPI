<?php

use App\Http\Controllers\Adv\AdvAttachController;
use App\Http\Controllers\Adv\AdvController;
use App\Http\Controllers\Album\AlbumController;
use App\Http\Controllers\Album\AlbumPhotoController;
use App\Http\Controllers\Article\ArticleController;
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

Route::group(['middleware' =>[ 'changeLang','checkPassword' ,'auth:api' ] ] ,function () {
    Route::apiResource('user' , UserController::class);
    Route::get('profile' , [UserController::class,'profile']);
    Route::put('profile/update' , [UserController::class,'profileUpdate']);
    Route::put('profile/password' , [UserController::class,'profilePassword']);

    Route::apiResource('role', RoleController::class);
    Route::apiResource('article',ArticleController::class);
    Route::get('articles/me' , [ArticleController::class,'userArticle']);

    Route::apiResource('adv',AdvController::class);
    Route::get('advs/me' , [AdvController::class,'userAdv']);

    Route::apiResource('attachment',AdvAttachController::class)->only('store','destroy');

    Route::apiResource('album', AlbumController::class);
    Route::apiResource('albumPhoto', AlbumPhotoController::class)->only('store','destroy');
});


