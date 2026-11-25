<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $shop = $request->user()->shop;

        // Premier passage : le commerçant doit d'abord créer sa boutique
        if (! $shop) {
            return redirect()->route('dashboard.shop.create');
        }

        return view('dashboard.index', [
            'shop' => $shop,
            'nouvellesCommandes' => $shop->orders()->where('statut', 'nouvelle')->count(),
            'nbProduits' => $shop->products()->count(),
            'ventesDuJour' => $shop->orders()
                ->whereDate('created_at', today())
                ->where('statut', '!=', 'annulee')
                ->sum('total'),
        ]);
    }
}
