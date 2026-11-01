<?php
namespace App\Services;
 
use App\Models\Order;
use App\Models\Shop;
 
class WhatsAppMessageBuilder
{
    public static function url(Shop $shop, Order $order): string
    {
        $order->loadMissing('items');
 
        $lignes = $order->items->map(function ($item) {
            $sousTotal = number_format($item->quantite * $item->prix_unitaire, 0, ',', ' ');
 
            return "- {$item->quantite} x {$item->nom_produit} : {$sousTotal} FCFA";
        })->implode("\n");
 
        $total = number_format($order->total, 0, ',', ' ');
 
        $texte = "Bonjour {$shop->nom}, nouvelle commande {$order->reference}\n\n"
            . "{$lignes}\n\n"
            . "Total : {$total} FCFA\n\n"
            . "Nom : {$order->client_nom}\n"
            . "Tél : {$order->client_tel}\n"
            . 'Adresse : ' . ($order->adresse ?: 'non précisée');
 
        if ($order->note) {
            $texte .= "\nNote : {$order->note}";
        }
 
        $numero = preg_replace('/\D/', '', $shop->whatsapp);
 
        return 'https://wa.me/' . $numero . '?text=' . rawurlencode($texte);
    }
}