<?php

use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SubCategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\SubSubCategoryController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CustomerAddressController;
use App\Http\Controllers\DeliveyMethodController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PaymentSystemController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserController;
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
    'branches' => BranchController::class,
    'countries' => CountryController::class,
    'products'=>ProductController::class,
    'categories'=>CategoryController::class,
    'sub_categories'=>SubCategoryController::class,
    'sub_sub_categories'=>SubSubCategoryController::class,
    'delivery-methods'=>DeliveyMethodController::class,
    'payment-types'=>PaymentMethodController::class,
]);

Route::get('/product-search', [ProductController::class, 'search']);
Route::get('/similar-products/{slug}', [ProductController::class, 'similarProducts']);
Route::get('/best-offers', [ProductController::class, 'bestOffers']);

Route::get('/discounts', [DiscountController::class, 'discounts']);
Route::get('/discount-products', [DiscountController::class, 'discountProducts']);

Route::get('/cards', [CardController::class, 'index']);

Route::get('/orders', [OrderController::class, 'index'])->middleware(['auth:sanctum']);
Route::post('/orders', [OrderController::class, 'store'])->middleware(['auth:sanctum']);
Route::get('/order-status-list', [OrderController::class, 'orderStatus'])->middleware(['auth:sanctum']);
Route::post('/order-cancelled/{id}', [OrderController::class, 'orderCancelled'])->middleware(['auth:sanctum']);

Route::get('/comments', [CommentController::class, 'index']);
Route::post('/comments', [CommentController::class, 'store'])->middleware(['auth:sanctum']);

Route::get('/payment-types', [PaymentTypeController::class, 'index']);

Route::get('/big-banner', [BannerController::class, 'bigBanner']);
Route::get('/small-banner', [BannerController::class, 'smallBanner']);
Route::get('/setting', [SettingController::class, 'index']);

Route::get('/user/me', [UserController::class, 'index'])->middleware(['auth:sanctum']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
Route::post('/register-verify', [AuthController::class, 'registerVerifyCode']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login-verify', [AuthController::class, 'loginVerifyCode']);
Route::post('/login', [AuthController::class, 'login']);


