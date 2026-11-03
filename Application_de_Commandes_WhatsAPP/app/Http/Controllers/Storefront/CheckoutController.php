<?php

namespace App\Http\Controllers\Storefront;
 
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shop;
use App\Services\Cart;
use App\Services\WhatsAppMessageBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
 
class CheckoutController extends Controller
{
    public function create(Shop $shop)
    {
        $cart = new Cart($shop);
 
        if ($cart->count() === 0) {
            return redirect()->route('shop.show', $shop);
        }
 
        return view('storefront.checkout', [
            'shop' => $shop,
            'lines' => $cart->lines(),
            'total' => $cart->total(),
            'cartCount' => $cart->count(),
        ]);
    }
 
    public function store(Request $request, Shop $shop)
    {
        $data = $request->validate([
            'client_nom' => 'required|string|max:100',
            'client_telephone' => 'required|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:500',
        ]);
 
        $cart = new Cart($shop);
        $lines = $cart->lines();
 
        if ($lines->isEmpty()) {
            return redirect()->route('shop.show', $shop);
        }
 
        $order = DB::transaction(function () use ($shop, $lines, $data) {
            $total = 0;
            $items = [];
 
            foreach ($lines as $line) {
                // Verrou pour éviter de vendre deux fois le dernier article
                $product = Product::lockForUpdate()->findOrFail($line['product']->id);
 
                if ($product->stock < $line['quantite']) {
                    throw ValidationException::withMessages([
                        'panier' => "Stock insuffisant pour {$product->nom} (reste {$product->stock}).",
                    ]);
                }
 
                $total += $product->prix * $line['quantite'];
 
                $items[] = [
                    'product_id' => $product->id,
                    'nom_produit' => $product->nom,
                    'quantite' => $line['quantite'],
                    'prix_unitaire' => $product->prix,
                ];
 
                $product->decrement('stock', $line['quantite']);
            }
 
            $order = $shop->orders()->create($data + [
                'reference' => Order::genererReference(),
                'total' => $total,
                'statut' => 'nouvelle',
            ]);
 
            $order->items()->createMany($items);
 
            return $order;
        });
 
        $cart->clear();
 
        // La commande est enregistrée, on ouvre WhatsApp avec le message pré-rempli
        return redirect()->away(WhatsAppMessageBuilder::url($shop, $order));
    }
}