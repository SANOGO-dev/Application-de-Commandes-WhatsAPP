
<?php
 namespace App\Services;
 
use App\Models\Shop;
use Illuminate\Support\Collection;
 
class Cart
{
    public function __construct(private Shop $shop)
    {
    }
 
    private function key(): string
    {
        return 'cart.' . $this->shop->id;
    }
 
    public function add(int $productId, int $quantite = 1): void
    {
        $items = session($this->key(), []);
        $items[$productId] = min(($items[$productId] ?? 0) + $quantite, 99);
        session([$this->key() => $items]);
    }
 
    public function set(int $productId, int $quantite): void
    {
        $items = session($this->key(), []);
 
        if ($quantite <= 0) {
            unset($items[$productId]);
        } else {
            $items[$productId] = min($quantite, 99);
        }
 
        session([$this->key() => $items]);
    }
 
    public function remove(int $productId): void
    {
        $this->set($productId, 0);
    }
 
    public function clear(): void
    {
        session()->forget($this->key());
    }
 
    // Retourne [['product' => Product, 'quantite' => int, 'sous_total' => int], ...]
    public function lines(): Collection
    {
        $items = session($this->key(), []);
 
        $products = $this->shop->products()
            ->where('actif', true)
            ->whereIn('id', array_keys($items))
            ->get()
            ->keyBy('id');
 
        return collect($items)
            ->map(function ($quantite, $id) use ($products) {
                $product = $products->get($id);
 
                return $product ? [
                    'product' => $product,
                    'quantite' => $quantite,
                    'sous_total' => $product->prix * $quantite,
                ] : null;
            })
            ->filter()
            ->values();
    }
 
    public function total(): int
    {
        return $this->lines()->sum('sous_total');
    }
 
    public function count(): int
    {
        return $this->lines()->sum('quantite');
    }
}