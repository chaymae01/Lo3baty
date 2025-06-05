@extends('admin.layouts.app')

@section('title', 'Gestion des Annonces')

@section('content')
<div class="flex">
    @include('admin.layouts.sidebar')
    <div class="flex-1 p-6 space-y-6">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Gestion des Annonces</h1>
            </div>

            {{-- Filtre par statut --}}
            <div class="mb-6 bg-white p-4 rounded-lg shadow">
                <form method="GET" action="{{ route('admin.annonces.index') }}" class="flex items-center space-x-4">
                    <label for="statut" class="text-sm font-medium text-gray-700">Filtrer par statut :</label>
                    <select name="statut" id="statut" onchange="this.form.submit()" 
                            class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Tous les statuts</option>
                        @foreach($statuts as $statut)
                            <option value="{{ $statut }}" {{ request('statut') == $statut ? 'selected' : '' }}>
                                {{ ucfirst($statut) }}
                            </option>
                        @endforeach
                    </select>
                    @if(request('statut'))
                        <a href="{{ route('admin.annonces.index') }}" 
                           class="text-sm text-gray-600 hover:text-gray-800 ml-2">
                            Réinitialiser
                        </a>
                    @endif
                </form>
            </div>

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-4 border-b border-gray-200 text-left">ID</th>
                                <th class="py-3 px-4 border-b border-gray-200 text-left">Objet</th>
                                <th class="py-3 px-4 border-b border-gray-200 text-left">Partenaire</th>
                                <th class="py-3 px-4 border-b border-gray-200 text-left">Prix/J</th>
                                <th class="py-3 px-4 border-b border-gray-200 text-left">Statut</th>
                                <th class="py-3 px-4 border-b border-gray-200 text-left">Premium</th>
                                <th class="py-3 px-4 border-b border-gray-200 text-left">Dates</th>
                                <th class="py-3 px-4 border-b border-gray-200 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($annonces as $annonce)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 border-b border-gray-200">{{ $annonce->id }}</td>
                                <td class="py-3 px-4 border-b border-gray-200">{{ $annonce->objet->nom ?? '-' }}</td>
                                <td class="py-3 px-4 border-b border-gray-200">
                                    {{ $annonce->partenaire->nom ?? '-' }}
                                </td>
                                <td class="py-3 px-4 border-b border-gray-200">{{ number_format($annonce->prix_journalier, 2) }} €</td>
                                <td class="py-3 px-4 border-b border-gray-200">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                       {{ $annonce->statut === 'active' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                       {{ ucfirst($annonce->statut) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 border-b border-gray-200">
                                    @if($annonce->premium)
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">
                                            {{ $annonce->premium_periode }} jours
                                        </span>
                                    @else
                                        <span class="text-gray-500">Non</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 border-b border-gray-200 text-sm">
                                    {{ $annonce->date_debut->format('d/m/Y') }} - 
                                    {{ $annonce->date_fin->format('d/m/Y') }}
                                </td>
                                <td class="py-3 px-4 border-b border-gray-200">
                                    <a href="{{ route('admin.annonces.show', $annonce) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        Voir
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 px-6 py-3 bg-gray-50 border-t border-gray-200">
                    @if(request('statut'))
                        {{ $annonces->appends(['statut' => request('statut')])->links() }}
                    @else
                        {{ $annonces->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection