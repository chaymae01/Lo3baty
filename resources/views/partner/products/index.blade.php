@extends('layouts.partner')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Mes Produits</h1>
        <a href="{{ route('partner.products.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">+ Ajouter</a>
    </div>

    @if(session('success'))
        <div class="mb-4 text-green-600 font-medium">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" class="mb-4 flex flex-wrap items-center gap-4">
        <div>
            <label for="categorie_id" class="text-sm text-gray-700">Catégorie</label>
            <select name="categorie_id" id="categorie_id" class="block w-full border rounded px-3 py-1.5">
                <option value="">Toutes</option>
                @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}" {{ request('categorie_id') == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="etat" class="text-sm text-gray-700">État</label>
            <select name="etat" id="etat" class="block w-full border rounded px-3 py-1.5">
                <option value="">Tous</option>
                <option value="neuf" {{ request('etat') == 'neuf' ? 'selected' : '' }}>Neuf</option>
                <option value="bon état" {{ request('etat') == 'bon état' ? 'selected' : '' }}>Bon état</option>
                <option value="usé" {{ request('etat') == 'usé' ? 'selected' : '' }}>Usé</option>
            </select>
        </div>

        <div class="self-end">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Filtrer
            </button>
        </div>
    </form>

    <a href="{{ route('partner.products.index') }}" class="text-sm text-gray-500 hover:text-gray-700 underline">
        Réinitialiser les filtres
    </a>

    <div class="overflow-x-auto bg-white shadow-md rounded">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100">
                <tr>
                    @php
                        $isNomAsc = request('sort_nom') === 'asc';
                        $isNomDesc = request('sort_nom') === 'desc';
                        $nextSortNom = $isNomAsc ? 'desc' : 'asc';
                    @endphp

                    <th class="p-3 text-left">
                        <a href="{{ route('partner.products.index', array_merge(request()->except('sort_nom'), ['sort_nom' => $nextSortNom])) }}"
                        class="flex items-center gap-1 text-gray-700 hover:text-blue-600">
                            Nom
                            @if($isNomAsc)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                                </svg>
                            @elseif($isNomDesc)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            @else
                                <svg class="w-4 h-4 opacity-30" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            @endif
                        </a>
                    </th>
                    <th class="p-3">Catégorie</th>
                    @php
                        $isAsc = request('sort_price') === 'asc';
                        $isDesc = request('sort_price') === 'desc';
                        $nextSort = $isAsc ? 'desc' : 'asc';
                    @endphp

                    <th class="p-3">
                        <a href="{{ route('partner.products.index', array_merge(request()->query(), ['sort_price' => $nextSort])) }}"
                        class="flex items-center gap-1 text-gray-700 hover:text-blue-600">
                            Prix
                            @if($isAsc)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                                </svg>
                            @elseif($isDesc)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            @else
                                <svg class="w-4 h-4 opacity-30" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            @endif
                        </a>
                    </th>
                    <th class="p-3">Ville</th>
                    <th class="p-3">État</th>
                    <th class="p-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $product->nom }}</td>
                    <td class="p-3">{{ $product->categorie->nom ?? '-' }}</td>
                    <td class="p-3">{{ $product->prix_journalier }} MAD/j</td>
                    <td class="p-3">{{ $product->ville }}</td>
                    <td class="p-3">{{ $product->etat }}</td>
                    <td class="p-3 text-right space-x-2">
                        <a href="{{ route('partner.products.show', $product) }}" class="text-gray-600 hover:underline">Voir</a>
                        <a href="{{ route('partner.products.edit', $product) }}" class="text-blue-500 hover:underline">Modifier</a>
                        <form action="{{ route('partner.products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 hover:underline">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($products->isEmpty())
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-400">Aucun produit trouvé</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
