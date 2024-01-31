<?php

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

Route::post('/storecategory', [CategoriesController::class, 'store']);
Route::get('/getcategory', [CategoriesController::class, 'index']);
Route::get('/getcategory/{id}', [CategoriesController::class, 'show']);
Route::put('/updatecategory/{id}', [CategoriesController::class, 'update']);
Route::delete('/deletecategory/{id}', [CategoriesController::class, 'destroy']);
Route::post('/restorecategory/{id}', [CategoriesController::class, 'restore']);



Route::post('/storeImage', [ImageController::class, 'store']);
Route::get('/getImage', [ImageController::class, 'index']);
Route::get('/getImage/{id}', [ImageController::class, 'show']);
Route::put('/updateImage/{id}', [ImageController::class, 'update']);
Route::delete('/deleteImage/{id}', [ImageController::class, 'destroy']);
Route::post('/restoreImage/{id}', [ImageController::class, 'restore']);



Route::group(['middleware' => ['auth:sanctum']], function () {
    
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/connectedUser', [AuthController::class, 'connectedUser']);
    
  
   
    
  
});
