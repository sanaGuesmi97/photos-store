<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\Image\ImageController;
use App\Http\Controllers\User\AuthController;
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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::apiResource('category', CategoriesController::class);
Route::apiResource('image', ImageController::class);
Route::apiResource('article', ArticleController::class);
Route::post('/restore-article/{id}', [ArticleController::class, 'restore']);
Route::post('/restore-image/{id}', [ImageController::class, 'restore']);

Route::group(['middleware' => ['auth:sanctum']], function () { 
 Route::post('/logout', [AuthController::class, 'logout']);
 Route::get('/connectedUser', [AuthController::class, 'connectedUser']);
   

    
  
   
    
  
});
