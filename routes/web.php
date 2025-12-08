<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\StripeCheckoutController;
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

// Routes non protégées (Routes qui ne nécessitent pas l’authentification)
Route::get('/', static function () {
    return view('welcome');
});

// Routes non protégées (Routes qui ne nécessitent pas l’authentification)
Route::get('/shoppingCart', ShoppingCartController::class)->name('cart.index');

// Routes non protégées (Routes qui ne nécessitent pas l’authentification)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Routes non protégées (Routes qui ne nécessitent pas l’authentification)
Route::get('/checkout', [StripeCheckoutController::class, 'create']);
Route::get('/checkout/success', [StripeCheckoutController::class, 'success']);
Route::post('/paymentIntent', [StripeCheckoutController::class, 'PaymentIntent']);



// Routes protégées (Routes qui nécessitent l’authentification)
Route::post('/saveOrder', OrderController::class)
    ->middleware('auth')
    ->name('orders.save');

// Routes protégées (Routes qui nécessitent l’authentification)
Route::get('/dashboard', static function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes protégées (Routes qui nécessitent l’authentification)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
