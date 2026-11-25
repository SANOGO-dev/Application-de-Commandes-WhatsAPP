<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
class ShopSettingsController extends Controller

{
    // Mots interdits comme slug : ils entreraient en conflit avec les routes du site
    private const RESERVES = [
        'dashboard', 'admin', 'login', 'register', 'logout', 'profile', 'password',
        'forgot-password', 'reset-password', 'verify-email', 'confirm-password', 'email', 'up',
    ];

    public function create(Request $request)
    {
        if ($request->user()->shop) {
            return redirect()->route('dashboard');
        }

        return view('dashboard.shop.create');
    }

    public function store(Request $request)
    {
        if ($request->user()->shop) {
            return redirect()->route('dashboard');
        }

        // Nettoyage avant validation : slug propre, numéro sans espaces ni "+"
        $request->merge([
            'slug' => Str::slug($request->input('slug') ?: $request->input('nom', '')),
            'whatsapp' => preg_replace('/\D/', '', (string) $request->input('whatsapp')),
        ]);

        $data = $request->validate([
            'nom' => 'required|string|max:100',
            'slug' => ['required', 'max:60', Rule::unique('shops', 'slug'), Rule::notIn(self::RESERVES)],
            'whatsapp' => ['required', 'regex:/^\d{8,15}$/'],
            'description' => 'nullable|string|max:500',
            'couleur' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
        ], [
            'slug.unique' => 'Ce lien est déjà pris, choisis-en un autre.',
            'slug.not_in' => 'Ce lien est réservé, choisis-en un autre.',
            'whatsapp.regex' => "Entre l'indicatif et le numéro, par exemple 2250700000000.",
        ]);

        $request->user()->shop()->create([
            'nom' => $data['nom'],
            'slug' => $data['slug'],
            'whatsapp' => $data['whatsapp'],
            'description' => $data['description'] ?? null,
            'couleur' => $data['couleur'] ?? '#16a34a',
            'statut_abonnement' => 'essai',
            'expire_le' => now()->addDays(7),
        ]);

        return redirect()->route('dashboard')->with('success', 'Ta boutique est créée. Essai gratuit de 7 jours.');
    }
}