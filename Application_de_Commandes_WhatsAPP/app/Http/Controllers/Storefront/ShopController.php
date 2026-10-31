<?php


namespace App\Http\Controllers\Storefront;
 
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Shop;
use App\Services\Cart;
use Illuminate\Http\Request;
 
class ShopController extends Controller
{
    public function show(Request $request, Shop $shop)
    {
        $products = $shop->products()
            ->where('actif', true)
            ->when($request->query('category'), fn ($q, $id) => $q->where('category_id', $id))
            ->latest()
            ->get();
 
        return view('storefront.show', [
            'shop' => $shop,
            'categories' => $shop->categories,
            'products' => $products,
            'cartCount' => (new Cart($shop))->count(),
        ]);
    }
 
    public function product(Shop $shop, Product $product)
    {
        abort_unless($product->actif, 404);
 
        return view('storefront.product', [
            'shop' => $shop,
            'product' => $product,
            'cartCount' => (new Cart($shop))->count(),
        ]);
    }
}