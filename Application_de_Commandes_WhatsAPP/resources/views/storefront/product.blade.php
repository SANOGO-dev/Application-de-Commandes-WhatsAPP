@extends('layouts.storefront')
 
@section('title', $product->nom . ' - ' . $shop->nom)
 
@section('content')
    <p><a href="{{ route('shop.show', $shop) }}" class="muted">← Retour à la boutique</a></p>
 
    <div class="box">
        <div class="img" style="border-radius:12px;margin-bottom:12px">
            @if ($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->nom }}">
            @else
                🛍️
            @endif
        </div>
 
        <h1>{{ $product->nom }}</h1>
        <div class="prix" style="font-size:20px">{{ $product->prix_formate }}</div>
 
        @if ($product->description)
            <p>{{ $product->description }}</p>
        @endif
 
        @if ($product->stock > 0)
            <p class="muted">{{ $product->stock }} en stock</p>
 
            <form method="POST" action="{{ route('cart.add', [$shop, $product]) }}">
                @csrf
                <label for="quantite">Quantité</label>
                <input type="number" id="quantite" name="quantite" value="1" min="1" max="{{ min($product->stock, 99) }}" class="qty">
                <div style="margin-top:12px">
                    <button type="submit" class="btn">Ajouter au panier</button>
                </div>
            </form>
        @else
            <button class="btn" disabled>Épuisé</button>
        @endif
    </div>
@endsection