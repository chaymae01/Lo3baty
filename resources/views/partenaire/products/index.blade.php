@extends('layouts.partenaire')

@section('content')
<main id="dashboard-content" class="flex-1 p-8 overflow-y-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-extrabold text-indigo-700">🎁 Mes Produits</h1>
        <a href="{{ route('partenaire.products.create') }}"
           class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition-all">
            + Ajouter
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 text-green-600 font-medium bg-green-100 px-4 py-2 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filtres --}}
    <form method="GET" class="mb-6 flex flex-wrap items-end gap-4 bg-white p-4 rounded shadow">
        <div>
            <label for="categorie_id" class="block text-sm text-gray-700 mb-1">Catégorie</label>
            <select name="categorie_id" id="categorie_id" class="block w-48 border rounded px-3 py-2">
                <option value="">Toutes</option>
                @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}" {{ request('categorie_id') == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="etat" class="block text-sm text-gray-700 mb-1">État</label>
            <select name="etat" id="etat" class="block w-48 border rounded px-3 py-2">
                <option value="">Tous</option>
                <option value="Neuf" {{ request('etat') == 'Neuf' ? 'selected' : '' }}>Neuf</option>
                <option value="Bon état" {{ request('etat') == 'Bon état' ? 'selected' : '' }}>Bon état</option>
                <option value="Usage" {{ request('etat') == 'Usage' ? 'selected' : '' }}>Usé</option>

            </select>
        </div>

        <div>
            <label for="tranche_age" class="block text-sm text-gray-700 mb-1">Tranche d'âge</label>
            <select name="tranche_age" id="tranche_age" class="block w-48 border rounded px-3 py-2">
                <option value="">Toutes</option>
                <option value="<3" {{ request('tranche_age') == '<3' ? 'selected' : '' }}>&lt; 3 ans</option>
                <option value="3-5" {{ request('tranche_age') == '3-5' ? 'selected' : '' }}>3–5 ans</option>
                <option value="6-8" {{ request('tranche_age') == '6-8' ? 'selected' : '' }}>6–8 ans</option>
                <option value="9-12" {{ request('tranche_age') == '9-12' ? 'selected' : '' }}>9–12 ans</option>
                <option value="13+" {{ request('tranche_age') == '13+' ? 'selected' : '' }}>13 ans et plus</option>
            </select>
        </div>

        <div>
            <label for="search" class="block text-sm text-gray-700 mb-1">Recherche</label>
            <input type="text" name="search" id="search" placeholder="Nom du produit"
                value="{{ request('search') }}"
                class="block w-60 border rounded px-3 py-2">
        </div>

        <div>
            <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                Filtrer
            </button>
        </div>

        @if(request()->has('categorie_id') || request()->has('etat') || request()->has('tranche_age') || request()->has('search'))
            <a href="{{ route('partenaire.products.index') }}"
            class="text-sm text-gray-500 hover:text-gray-700 underline ml-auto">
                Réinitialiser les filtres
            </a>
        @endif
    </form>

    {{-- Grille des produits --}}
    @if($products->isEmpty())
        <p class="text-gray-500 text-lg">Aucun produit trouvé.</p>
    @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $product)
                <div class="relative bg-white rounded-xl shadow p-6 hover:shadow-xl transition-all flex flex-col">
                    {{-- Labels above image --}}
                    <div class="absolute top-3 left-3 flex flex-col gap-1 z-10">
                        @if($product->tranche_age)
                            <div class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded-full shadow">
                                {{ $product->tranche_age }} ans
                            </div>
                        @endif

                        @php
                            $avgNote = $product->note_moyenne ?? ($product->objet->note_moyenne ?? null);
                        @endphp

                        @if($avgNote)
                            <div class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2 py-1 rounded-full shadow">
                                ⭐ {{ $avgNote }}/5
                            </div>
                        @endif
                    </div>
                    {{-- Image --}}
                    @if($product->images->isNotEmpty())
                        <div x-data="{ activeSlide: 0 }" class="relative w-full h-48 mb-4">
                            {{-- Slides --}}
                            <template x-for="(img, index) in {{ $product->images->toJson() }}" :key="index">
                                <img :src="'/storage/' + img.url"
                                    alt="Image de {{ $product->nom }}"
                                    class="absolute top-0 left-0 w-full h-48 object-cover rounded"
                                    x-show="activeSlide === index"
                                    x-transition>
                            </template>

                            {{-- Boutons gauche/droite --}}
                            <button @click="activeSlide = (activeSlide === 0) ? {{ $product->images->count() - 1 }} : activeSlide - 1"
                                    class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-white/70 rounded-full p-1 shadow hover:bg-white">
                                ‹
                            </button>
                            <button @click="activeSlide = (activeSlide === {{ $product->images->count() - 1 }}) ? 0 : activeSlide + 1"
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white/70 rounded-full p-1 shadow hover:bg-white">
                                ›
                            </button>

                            {{-- Indicateurs --}}
                            <div class="absolute bottom-2 left-1/2 transform -translate-x-1/2 flex space-x-1">
                                <template x-for="(img, index) in {{ $product->images->toJson() }}" :key="index">
                                    <div :class="activeSlide === index ? 'bg-indigo-600' : 'bg-gray-300'"
                                        class="w-2 h-2 rounded-full"></div>
                                </template>
                            </div>
                        </div>
                    @else
                        <div class="w-full h-48 bg-gray-100 rounded flex items-center justify-center text-gray-400 text-sm mb-4">
                            Aucune image disponible
                        </div>
                    @endif


                    {{-- Détails --}}
                    <h2 class="text-xl font-semibold text-indigo-600">{{ $product->nom }}</h2>
                    <p class="text-sm text-gray-600 mt-1 mb-2">{{ Str::limit($product->description, 100) }}</p>

                    <div class="flex justify-between items-center text-sm text-gray-500 mb-3">
                        <span>Catégorie: {{ $product->categorie->nom ?? '-' }}</span>
                        <span>Ville: {{ $product->ville }}</span>
                    </div>

                    <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded-full mb-4">
                        {{ $product->etat }}
                    </span>

                    {{-- Actions --}}
                    <div class="mt-auto flex justify-between gap-2">
                        <a href="{{ route('partenaire.products.show', $product) }}"
                           class="flex-1 text-center bg-gray-100 text-gray-700 px-3 py-2 rounded hover:bg-gray-200 text-sm">
                            Voir
                        </a>
                        <a href="{{ route('partenaire.products.edit', $product) }}"
                           class="flex-1 text-center bg-blue-100 text-blue-700 px-3 py-2 rounded hover:bg-blue-200 text-sm">
                            Modifier
                        </a>
                        <form action="{{ route('partenaire.products.destroy', $product) }}" method="POST"
                              onsubmit="return confirm('Confirmer la suppression ?');" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full bg-red-100 text-red-700 px-3 py-2 rounded hover:bg-red-200 text-sm">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</main>
@endsection
