<?php
use App\Http\Controllers\Storefront\CartController;
use App\Http\Controllers\Storefront\CheckoutController;
use App\Http\Controllers\Storefront\ShopController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ShopSettingsController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/boutique/creer', [ShopSettingsController::class, 'create'])->name('dashboard.shop.create');
    Route::post('/boutique', [ShopSettingsController::class, 'store'])->name('dashboard.shop.store');
});
Route::middleware('shop.active')
    ->prefix('{shop}')
    ->where(['shop' => '(?!(?:dashboard|admin|login|register|logout|profile|password|forgot-password|reset-password|verify-email|confirm-password|email|up)$)[a-z0-9-]+'])
    ->scopeBindings()
    ->group(function () {
        Route::get('/', [ShopController::class, 'show'])->name('shop.show');
        Route::get('/produit/{product}', [ShopController::class, 'product'])->name('shop.product');
 
        Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
        Route::post('/panier/ajouter/{product}', [CartController::class, 'add'])->name('cart.add');
        Route::patch('/panier/{product}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/panier/{product}', [CartController::class, 'remove'])->name('cart.remove');
 
        Route::get('/commander', [CheckoutController::class, 'create'])->name('checkout.create');
        Route::post('/commander', [CheckoutController::class, 'store'])->name('checkout.store');
    });