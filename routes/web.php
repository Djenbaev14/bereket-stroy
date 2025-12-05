<?php

use App\Http\Controllers\PdfController;
use App\Models\Product;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/admin/test', function () {
    $rec = auth()->user();

    Notification::make()
        ->title('Seding test notifi')
        ->sendToDatabase($rec);

    dd('done sending');
});

Route::any('/handle/{paysys}', function ($paysys) {
    (new Goodoneuz\PayUz\PayUz)->driver($paysys)->handle();
});

//redirect to payment system or payment form
Route::any('/pay/{paysys}/{key}/{amount}', function ($paysys, $key, $amount) {
    $model = Goodoneuz\PayUz\Services\PaymentService::convertKeyToModel($key);
    $url = request('redirect_url', '/'); // redirect url after payment completed
    $pay_uz = new Goodoneuz\PayUz\PayUz;
    $pay_uz
        ->driver($paysys)
        ->redirect($model, $amount, 860, $url);
});

Route::get('/product/{product}/print-credit', function (Product $product) {
    $price = $product->price;
    $calc = fn($p, $percent, $month) =>
    number_format((($p + ($p * $percent / 100)) / $month), 0, '.', ' ');

    return view('filament.credit-info-print', [
        'price'   => $price,
        'm3'      => $calc($price, 15, 3),
        'm6'      => $calc($price, 25, 6),
        'm9'      => $calc($price, 32, 9),
        'm12'     => $calc($price, 38, 12),
        'm18'     => $calc($price, 57, 18),
        'm24'     => $calc($price, 76, 24),
        'product' => $product,
    ]);
})->name('product.print-credit');
