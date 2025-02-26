<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SubCategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\SubSubCategoryController;
use App\Http\Controllers\Api\BrandController;
use App\Models\Country;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('products',ProductController::class);
Route::apiResource('categories',CategoryController::class);
Route::apiResource('sub_categories',SubCategoryController::class);
Route::apiResource('sub_sub_categories',SubSubCategoryController::class);

Route::get('/brands', [BrandController::class,'index'])->middleware('auth:sanctum');
Route::get('/countries', [BrandController::class,'country']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/register-verify', [AuthController::class, 'registerVerifyCode']);
Route::post('/register', [AuthController::class, 'register']);
// Route::post('/form', [AuthController::class, 'form'])->middleware('auth:sanctum');




