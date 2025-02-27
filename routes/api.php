<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SubCategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\SubSubCategoryController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DeliveyMethodController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\UserAddressController;
use App\Models\Country;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::apiResources([
    'brands' => BrandController::class,
    'countries' => CountryController::class,
    'products'=>ProductController::class,
    'categories'=>CategoryController::class,
    'sub_categories'=>SubCategoryController::class,
    'sub_sub_categories'=>SubSubCategoryController::class,
    'delivery-methods'=>DeliveyMethodController::class,
    'user-addresses'=>UserAddressController::class,
    'payment-types'=>PaymentMethodController::class,
]);

Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum','token.expired']);

Route::post('/register-verify', [AuthController::class, 'registerVerifyCode']);
Route::post('/register', [AuthController::class, 'register']);


Route::post('/login-verify', [AuthController::class, 'loginVerifyCode']);
Route::post('/login', [AuthController::class, 'login']);




