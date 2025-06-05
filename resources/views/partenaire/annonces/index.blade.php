@extends('layouts.partenaire')

@section('content')
<main class="flex-1 p-8 overflow-y-auto bg-gray-50">
    <div class="max-w-6xl mx-auto">

        <h1 class="text-3xl font-bold text-indigo-700 mb-6">📋 Gérer mes annonces</h1>

        @if (session('ok'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow">
                {{ session('ok') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded shadow">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="GET" class="mb-6 flex flex-wrap items-end gap-4 bg-white p-4 rounded shadow">

            <div>
                <label for="search" class="block text-sm text-gray-700 mb-1">Recherche</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                    placeholder="Nom de l’objet"
                    class="w-60 border rounded px-3 py-2">
            </div>

            <div>
                <label for="categorie_id" class="block text-sm text-gray-700 mb-1">Catégorie</label>
                <select name="categorie_id" id="categorie_id" class="block w-48 border rounded px-3 py-2">
                    <option value="">Toutes</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('categorie_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->nom }}
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
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    Filtrer
                </button>
            </div>

            @if(request()->has('search') || request()->has('categorie_id') || request()->has('etat'))
                <a href="{{ route('partenaire.annonces.index') }}" class="text-sm text-gray-500 hover:underline ml-auto">
                    Réinitialiser
                </a>
            @endif

        </form>

        @if ($annonces->isEmpty())
            <p class="text-gray-500 text-center text-lg mt-12">Aucune annonce trouvée pour le moment.</p>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($annonces as $annonce)
                    @php
                        $objet = $annonce->objet;
                        $imageUrl = $objet && $objet->images->isNotEmpty()
                            ? asset('storage/' . $objet->images->first()->url)
                            : 'https://via.placeholder.com/300x200?text=Aucune+image';

                        $avgRating = $objet && $objet->evaluations->count()
                            ? round($objet->evaluations->avg('note'), 1)
                            : null;

                    @endphp

                    <div class="bg-white rounded-xl shadow-md p-4 flex flex-col space-y-3 hover:shadow-lg transition duration-200">
                        <div class="relative">
                            @if ($avgRating)
                                <div class="absolute top-2 right-2 bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded shadow">
                                    ⭐ {{ $avgRating }} / 5
                                </div>
                            @endif

                            <!-- Image -->
                            <img src="{{ $imageUrl }}"
                                alt="{{ $objet ? 'Image de ' . $objet->nom : 'Objet introuvable' }}"
                                class="w-full h-40 object-cover rounded-lg border">
                        </div>

                        <!-- Titre + Premium -->
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-800">
                                {{ $objet ? $objet->nom : 'Objet supprimé' }}
                            </h2>
                            @if ($annonce->premium)
                                <span class="text-yellow-500 text-sm font-bold">💎 Premium</span>
                            @endif
                        </div>

                        <!-- Statut -->
                        <span class="inline-block text-sm font-medium px-3 py-1 rounded-full w-fit
                            {{ $annonce->statut === 'active'
                                ? 'bg-green-100 text-green-700'
                                : 'bg-red-100 text-red-700' }}">
                            {{ $annonce->statut === 'active' ? '✅ Active' : '🛑 Inactive' }}
                        </span>

                        <!-- Coordonnées -->
                        <div class="text-sm text-gray-500">
                            <strong>📍 Adresse :</strong>
                            <span>{{ $annonce->adresse ?? '—' }}</span>
                        </div>

                        
                        <!-- Prix -->
                        <div class="text-sm text-gray-500">
                            <strong>💰 Prix :</strong>
                            <span>{{ number_format($annonce->prix_journalier, 2) }} DH / jour</span>
                        </div>

                        @if ($objet)
                            <!-- Boutons -->
                            <div class="flex flex-col gap-2 pt-2">
                                @if ($annonce->statut === 'active')
                                    <form action="{{ route('partenaire.annonces.archiver', $annonce) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full text-sm text-red-600 border border-red-300 px-4 py-2 rounded hover:bg-red-100 transition">
                                            🗃 Archiver
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('partenaire.annonces.activer', $annonce) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full text-sm text-green-600 border border-green-300 px-4 py-2 rounded hover:bg-green-100 transition">
                                            ✅ Activer
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('partenaire.annonces.edit', $annonce) }}"
                                   class="w-full text-sm text-blue-600 border border-blue-300 px-4 py-2 rounded hover:bg-blue-100 text-center transition">
                                    ✏️ Modifier
                                </a>

                                <!-- Supprimer -->
                                <form action="{{ route('partenaire.annonces.destroy', $annonce) }}" method="POST"
                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full text-sm text-red-700 border border-red-400 px-4 py-2 rounded hover:bg-red-100 transition">
                                    🗑 Supprimer
                                </button>
                                </form>
                            </div>
                        @else
                            <div class="text-xs text-red-500">Objet introuvable. Veuillez vérifier cette annonce.</div>
                        @endif

                    </div>
                @endforeach
            </div>
        @endif
    </div>
</main>
@endsection
