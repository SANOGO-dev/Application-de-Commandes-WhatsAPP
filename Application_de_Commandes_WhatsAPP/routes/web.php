<?php
use App\Http\Controllers\Storefront\CartController;
use App\Http\Controllers\Storefront\CheckoutController;
use App\Http\Controllers\Storefront\ShopController;
use Illuminate\Support\Facades\Route;


Route::middleware('shop.active')
    ->prefix('{shop}')
    ->where(['shop' => '(?!(?:dashboard|admin|login|register|logout|up)$)[a-z0-9-]+'])
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