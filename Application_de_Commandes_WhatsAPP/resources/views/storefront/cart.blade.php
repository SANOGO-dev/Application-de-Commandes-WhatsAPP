@extends('layouts.storefront')
 
@section('title', 'Panier - ' . $shop->nom)
 
@section('content')
    <h1>Mon panier</h1>
 
    @if ($lines->isEmpty())
        <div class="box">
            <p class="muted">Ton panier est vide.</p>
            <a href="{{ route('shop.show', $shop) }}" class="btn">Voir les produits</a>
        </div>
    @else
        <div class="box">
            @foreach ($lines as $line)
                <div class="line">
                    <div class="thumb">
                        @if ($line['product']->image)
                            <img src="{{ asset('storage/' . $line['product']->image) }}" alt="{{ $line['product']->nom }}">
                        @else
                            🛍️
                        @endif
                    </div>
 
                    <div class="grow">
                        <div class="nom">{{ $line['product']->nom }}</div>
                        <div class="muted">{{ $line['product']->prix_formate }}</div>
 
                        <div class="row" style="margin-top:8px; justify-content:flex-start">
                            <form method="POST" action="{{ route('cart.update', [$shop, $line['product']]) }}" class="row">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantite" value="{{ $line['quantite'] }}" min="0" max="99" class="qty">
                                <button type="submit" class="pill" style="cursor:pointer">OK</button>
                            </form>
 
                            <form method="POST" action="{{ route('cart.remove', [$shop, $line['product']]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="link-red">Retirer</button>
                            </form>
                        </div>
                    </div>
 
                    <div class="prix">{{ number_format($line['sous_total'], 0, ',', ' ') }} FCFA</div>
                </div>
            @endforeach
        </div>
 
        <div class="box row">
            <span class="total">Total</span>
            <span class="total">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
        </div>
 
        <a href="{{ route('checkout.create', $shop) }}" class="btn">Commander</a>
        <p style="text-align:center"><a href="{{ route('shop.show', $shop) }}" class="muted">Continuer mes achats</a></p>
    @endif
@endsection