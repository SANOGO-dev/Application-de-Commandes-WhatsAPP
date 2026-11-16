@extends('layouts.storefront')
 
@section('content')
    @if ($shop->description)
        <p class="muted">{{ $shop->description }}</p>
    @endif
 
    @if ($categories->isNotEmpty())
        <nav class="pills">
            <a href="{{ route('shop.show', $shop) }}" class="pill {{ request('category') ? '' : 'on' }}">Tout</a>
            @foreach ($categories as $category)
                <a href="{{ route('shop.show', [$shop, 'category' => $category->id]) }}"
                   class="pill {{ (string) request('category') === (string) $category->id ? 'on' : '' }}">
                    {{ $category->nom }}
                </a>
            @endforeach
        </nav>
    @endif
 
    @if ($products->isEmpty())
        <div class="box muted">Aucun produit disponible pour le moment.</div>
    @else
        <div class="grid">
            @foreach ($products as $product)
                <div class="card">
                    <a href="{{ route('shop.product', [$shop, $product]) }}" class="img">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->nom }}">
                        @else
                            🛍️
                        @endif
                    </a>
                    <div class="body">
                        <a href="{{ route('shop.product', [$shop, $product]) }}" class="nom">{{ $product->nom }}</a>
                        <div class="prix">{{ $product->prix_formate }}</div>
 
                        @if ($product->stock > 0)
                            <form method="POST" action="{{ route('cart.add', [$shop, $product]) }}" style="margin-top:auto">
                                @csrf
                                <button type="submit" class="btn">Ajouter</button>
                            </form>
                        @else
                            <button class="btn" disabled style="margin-top:auto">Épuisé</button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection