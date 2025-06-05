@extends('layouts.partenaire')

@section('content')
<main id="dashboard-content" class="flex-1 p-8 overflow-y-auto bg-gray-50">
    <div class="max-w-7xl mx-auto">

        <h1 class="text-3xl font-extrabold text-indigo-700 mb-8">🎯 Choisir un objet</h1>

        <!-- 🔎 Search + Filters -->
        <form method="GET" class="mb-8 flex flex-wrap items-end gap-4 bg-white p-4 rounded-xl shadow">

            <!-- Search -->
            <div>
                <label for="search" class="block text-sm text-gray-700 mb-1">Recherche</label>
                <input type="text" name="search" id="search"
                       value="{{ request('search') }}"
                       placeholder="Nom du jouet"
                       class="w-64 border rounded px-3 py-2">
            </div>

            <!-- Category -->
            <div>
                <label for="categorie_id" class="block text-sm text-gray-700 mb-1">Catégorie</label>
                <select name="categorie_id" id="categorie_id" class="w-48 border rounded px-3 py-2">
                    <option value="">Toutes</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('categorie_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- État -->
            <div>
                <label for="etat" class="block text-sm text-gray-700 mb-1">État</label>
                <select name="etat" id="etat" class="w-48 border rounded px-3 py-2">
                    <option value="">Tous</option>
                    <option value="Neuf" {{ request('etat') == 'Neuf' ? 'selected' : '' }}>Neuf</option>
                    <option value="Bon état" {{ request('etat') == 'Bon état' ? 'selected' : '' }}>Bon état</option>
                    <option value="Usage" {{ request('etat') == 'Usage' ? 'selected' : '' }}>Usé</option>
                </select>
            </div>

            <!-- Submit + Reset -->
            <div>
                <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                    Filtrer
                </button>
            </div>

            @if(request()->has('search') || request()->has('categorie_id') || request()->has('etat'))
                <a href="{{ route('partenaire.annonces.choose') }}"
                   class="text-sm text-gray-500 hover:underline ml-auto">
                    Réinitialiser les filtres
                </a>
            @endif
        </form>


        @if($objets->isEmpty())
            <div class="text-center text-gray-500 text-lg">
                Aucun objet disponible pour le moment.
            </div>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($objets as $objet)
                    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow hover:shadow-lg transition-all duration-200 flex flex-col">
                        <!-- Image -->
                        <img src="{{ $objet->images->first()
                            ? asset('storage/' . $objet->images->first()->url)
                            : 'https://via.placeholder.com/400x250?text=Aucune+image' }}"
                            alt="Image de {{ $objet->nom }}"
                            class="h-48 w-full object-cover">

                        <!-- Contenu -->
                        <div class="p-4 flex-1 flex flex-col">
                            <h2 class="text-lg font-semibold text-gray-800 mb-1">{{ $objet->nom }}</h2>

                            <p class="text-sm text-gray-500 mb-2">
                                📍 <strong>Ville:</strong> {{ $objet->ville }}
                            </p>

                            <p class="text-sm text-gray-500 mb-2 line-clamp-2">
                                📝 {{ $objet->description ?? 'Pas de description.' }}
                            </p>

                            <div class="mt-auto">
                                <a href="{{ route('partenaire.annonces.createForObject', $objet) }}"
                                   class="inline-block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded-lg transition">
                                    ➕ Créer une annonce
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</main>
@endsection
