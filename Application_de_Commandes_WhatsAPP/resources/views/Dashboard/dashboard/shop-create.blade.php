<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Créer ma boutique</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('dashboard.shop.store') }}">
                    @csrf

                    <div>
                        <x-input-label for="nom" value="Nom de la boutique" />
                        <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom" :value="old('nom')" required autofocus />
                        <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="slug" value="Lien de la boutique (facultatif)" />
                        <x-text-input id="slug" class="block mt-1 w-full" type="text" name="slug" :value="old('slug')" placeholder="ma-boutique" />
                        <p class="text-sm text-gray-500 mt-1">Si tu laisses vide, il sera créé à partir du nom.</p>
                        <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="whatsapp" value="Numéro WhatsApp (avec l'indicatif)" />
                        <x-text-input id="whatsapp" class="block mt-1 w-full" type="text" name="whatsapp" :value="old('whatsapp')" placeholder="2250700000000" required />
                        <x-input-error :messages="$errors->get('whatsapp')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="description" value="Description (facultatif)" />
                        <textarea id="description" name="description" rows="3" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="couleur" value="Couleur de la boutique" />
                        <input id="couleur" name="couleur" type="color" value="{{ old('couleur', '#16a34a') }}" class="mt-1 h-10 w-20">
                        <x-input-error :messages="$errors->get('couleur')" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <x-primary-button>Créer ma boutique</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
