<?php

namespace App\Http\Controllers\Storefront;
 
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Shop;
use App\Services\Cart;
use Illuminate\Http\Request;
 
class CartController extends Controller
{
    public function index(Shop $shop)
    {
        $cart = new Cart($shop);
 
        return view('storefront.cart', [
            'shop' => $shop,
            'lines' => $cart->lines(),
            'total' => $cart->total(),
            'cartCount' => $cart->count(),
        ]);
    }
 
    public function add(Request $request, Shop $shop, Product $product)
    {
        abort_unless($product->actif && $product->stock > 0, 404);
 
        $data = $request->validate(['quantite' => 'nullable|integer|min:1|max:99']);
 
        (new Cart($shop))->add($product->id, $data['quantite'] ?? 1);
 
        return back()->with('success', $product->nom . ' ajouté au panier');
    }
 
    public function update(Request $request, Shop $shop, Product $product)
    {
        $data = $request->validate(['quantite' => 'required|integer|min:0|max:99']);
 
        (new Cart($shop))->set($product->id, $data['quantite']);
 
        return back();
    }
 
    public function remove(Shop $shop, Product $product)
    {
        (new Cart($shop))->remove($product->id);
 
        return back();
    }
}