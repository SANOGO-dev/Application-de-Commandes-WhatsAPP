@extends('layouts.storefront')
 
@section('title', 'Commander - ' . $shop->nom)
 
@section('content')
    <h1>Finaliser la commande</h1>
 
    <div class="box">
        @foreach ($lines as $line)
            <div class="row" style="padding:4px 0">
                <span>{{ $line['quantite'] }} × {{ $line['product']->nom }}</span>
                <span>{{ number_format($line['sous_total'], 0, ',', ' ') }} FCFA</span>
            </div>
        @endforeach
        <hr style="border:0;border-top:1px solid var(--line)">
        <div class="row total">
            <span>Total</span>
            <span>{{ number_format($total, 0, ',', ' ') }} FCFA</span>
        </div>
    </div>
 
    <form method="POST" action="{{ route('checkout.store', $shop) }}" class="box">
        @csrf
 
        <label for="client_nom">Ton nom *</label>
        <input type="text" id="client_nom" name="client_nom" value="{{ old('client_nom') }}" required>
 
        <label for="client_tel">Ton numéro de téléphone *</label>
        <input type="tel" id="client_tel" name="client_tel" value="{{ old('client_tel') }}" placeholder="07 00 00 00 00" required>
 
        <label for="adresse">Adresse de livraison</label>
        <input type="text" id="adresse" name="adresse" value="{{ old('adresse') }}" placeholder="Quartier, repère...">
 
        <label for="note">Précision (facultatif)</label>
        <textarea id="note" name="note" rows="3">{{ old('note') }}</textarea>
 
        <div style="margin-top:16px">
            <button type="submit" class="btn">Envoyer ma commande sur WhatsApp</button>
        </div>
        <p class="muted" style="text-align:center">Tu seras redirigé vers WhatsApp avec ta commande déjà écrite.</p>
    </form>
    @endsection