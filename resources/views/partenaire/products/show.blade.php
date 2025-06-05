@extends('layouts.partenaire')

@section('content')
<main id="dashboard-content" class="flex-1 p-8 overflow-y-auto bg-gray-50">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-xl space-y-6">

        <h1 class="text-3xl font-extrabold text-indigo-700">{{ $product->nom }}</h1>

        {{-- Slideshow --}}
        @if($product->images->isNotEmpty())
            <div x-data="{ active: 0 }" class="relative w-full overflow-hidden rounded-xl border shadow mb-4">
                <div class="relative h-64 sm:h-80">
                    <template x-for="(img, index) in {{ $product->images->toJson() }}" :key="index">
                        <img :src="'/storage/' + img.url"
                             x-show="active === index"
                             class="absolute inset-0 w-full h-full object-cover transition-opacity duration-500 rounded-xl"
                             x-transition:enter="ease-out duration-300"
                             x-transition:leave="ease-in duration-200">
                    </template>

                    {{-- Navigation --}}
                    <button @click="active = (active === 0) ? {{ $product->images->count() - 1 }} : active - 1"
                            class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-white/80 p-2 rounded-full shadow hover:bg-white">
                        ‹
                    </button>
                    <button @click="active = (active === {{ $product->images->count() - 1 }}) ? 0 : active + 1"
                            class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-white/80 p-2 rounded-full shadow hover:bg-white">
                        ›
                    </button>

                    {{-- Indicators --}}
                    <div class="absolute bottom-3 left-1/2 transform -translate-x-1/2 flex gap-1">
                        <template x-for="(img, index) in {{ $product->images->toJson() }}" :key="index">
                            <div :class="active === index ? 'bg-indigo-600' : 'bg-gray-300'"
                                 class="w-2 h-2 rounded-full"></div>
                        </template>
                    </div>
                </div>
            </div>
        @else
            <div class="w-full h-64 bg-gray-100 rounded flex items-center justify-center text-gray-400 text-sm mb-4">
                Aucune image pour ce produit.
            </div>
        @endif

        {{-- Informations --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm text-gray-700">
            <div>
                <dt class="text-xs text-gray-500 uppercase mb-1">Description</dt>
                <dd>{{ $product->description ?: '—' }}</dd>
            </div>

            <div>
                <dt class="text-xs text-gray-500 uppercase mb-1">Catégorie</dt>
                <dd>{{ $product->categorie->nom ?? '—' }}</dd>
            </div>

            <div>
                <dt class="text-xs text-gray-500 uppercase mb-1">Ville</dt>
                <dd>{{ $product->ville }}</dd>
            </div>

            <div>
                <dt class="text-xs text-gray-500 uppercase mb-1">État</dt>
                <dd>
                    <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded-full">
                        {{ $product->etat }}
                    </span>
                </dd>
            </div>

            <div>
                <dt class="text-xs text-gray-500 uppercase mb-1">Tranche d'âge</dt>
                <dd>
                    <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full">
                        {{ $product->tranche_age }} ans
                    </span>
                </dd>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('partenaire.products.index') }}"
               class="inline-flex items-center text-indigo-600 hover:underline text-sm">
                ← Retour à la liste
            </a>
        </div>
    </div>
</main>

@endsection
