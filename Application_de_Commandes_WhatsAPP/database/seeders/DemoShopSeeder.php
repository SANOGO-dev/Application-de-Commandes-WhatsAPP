<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoShopSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'commercant@test.com'],
            ['name' => 'Commerçant Test', 'password' => 'password']
        );

        $shop = Shop::firstOrCreate(
            ['slug' => 'boutique-demo'],
            [
                'user_id' => $user->id,
                'nom' => 'Boutique Démo',
                // Remplace par TON numéro WhatsApp : indicatif + numéro, sans "+" ni espaces
                'whatsapp' => '2250700000000',
                'description' => 'Boutique de test pour vérifier le catalogue, le panier et la commande WhatsApp.',
                'couleur' => '#16a34a',
                'statut_abonnement' => 'essai',
                'expire_le' => now()->addDays(7),
            ]
        );

        $vetements = Category::firstOrCreate(['shop_id' => $shop->id, 'nom' => 'Vêtements']);
        $accessoires = Category::firstOrCreate(['shop_id' => $shop->id, 'nom' => 'Accessoires']);

        $produits = [
            ['nom' => 'T-shirt coton', 'prix' => 5000, 'stock' => 20, 'category_id' => $vetements->id],
            ['nom' => 'Pagne wax 6 yards', 'prix' => 12000, 'stock' => 10, 'category_id' => $vetements->id],
            ['nom' => 'Casquette brodée', 'prix' => 3500, 'stock' => 15, 'category_id' => $accessoires->id],
            ['nom' => 'Sac à main', 'prix' => 18000, 'stock' => 5, 'category_id' => $accessoires->id],
        ];

        foreach ($produits as $produit) {
            Product::firstOrCreate(
                ['shop_id' => $shop->id, 'nom' => $produit['nom']],
                $produit + ['description' => 'Produit de démonstration.', 'actif' => true]
            );
        }
    }
}