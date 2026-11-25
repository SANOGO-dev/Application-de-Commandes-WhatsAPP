<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $shop->nom }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-4 sm:rounded-lg">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                <p class="font-semibold">Le lien de ta boutique, à partager à tes clients :</p>
                <a href="{{ route('shop.show', $shop) }}" target="_blank" class="text-indigo-600 underline break-all">
                    {{ url('/' . $shop->slug) }}
                </a>
                <p class="mt-3 text-sm text-gray-600">
                    Abonnement : {{ $shop->statut_abonnement }}
                    @if ($shop->expire_le) · valable jusqu'au {{ $shop->expire_le->format('d/m/Y') }} @endif
                </p>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                <p>Nouvelles commandes : <strong>{{ $nouvellesCommandes }}</strong></p>
                <p>Produits : <strong>{{ $nbProduits }}</strong></p>
                <p>Ventes du jour : <strong>{{ number_format($ventesDuJour, 0, ',', ' ') }} FCFA</strong></p>
            </div>

        </div>
    </div>
</x-app-layout>