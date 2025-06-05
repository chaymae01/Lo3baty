@extends('admin.layouts.app')
@section('title', 'Gestion des reclamations')
@section('content')

<div class="flex">
    @include('admin.layouts.sidebar')
    <div class="flex-1 p-6 space-y-6">
        <div class="container mx-auto px-4 py-6">
            <h1 class="text-2xl font-bold mb-6">Gestion des Réclamations</h1>

            {{-- Filtre par statut --}}
            <div class="mb-6 bg-white p-4 rounded-lg shadow">
                <form method="GET" action="{{ route('admin.reclamations.index') }}" class="flex items-center space-x-4">
                    <label for="statut" class="text-sm font-medium text-gray-700">Filtrer par statut :</label>
                    <select name="statut" id="statut" onchange="this.form.submit()" 
                            class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Tous les statuts</option>
                        <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="resolue" {{ request('statut') == 'resolue' ? 'selected' : '' }}>Resolue</option>
                    </select>
                    @if(request('statut'))
                        <a href="{{ route('admin.reclamations.index') }}" 
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
                                <th class="py-3 px-4 border-b border-gray-200 text-left">Utilisateur</th>
                                <th class="py-3 px-4 border-b border-gray-200 text-left">Sujet</th>
                                <th class="py-3 px-4 border-b border-gray-200 text-left">Statut</th>
                                <th class="py-3 px-4 border-b border-gray-200 text-left">Date</th>
                                <th class="py-3 px-4 border-b border-gray-200 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reclamations as $reclamation)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4 border-b border-gray-200">{{ $reclamation->id }}</td>
                                <td class="py-3 px-4 border-b border-gray-200">
                                    @if($reclamation->utilisateur)
                                        {{ $reclamation->utilisateur->nom }}
                                    @else
                                        Utilisateur (ID: {{ $reclamation->client_id }}) non trouvé
                                    @endif
                                </td>
                                <td class="py-3 px-4 border-b border-gray-200">{{ Str::limit($reclamation->sujet, 50) }}</td>
                                <td class="py-3 px-4 border-b border-gray-200">
                                    @php
                                        // Conversion du statut pour la comparaison
                                        $statut = str_replace(' ', '_', strtolower($reclamation->statut));
                                        $statut = $statut === 'resolu' ? 'resolue' : $statut;
                                    @endphp
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $statut === 'en_attente' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($statut === 'resolue' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ ucfirst(str_replace('_', ' ', $statut)) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 border-b border-gray-200">
                                    {{ $reclamation->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="py-3 px-4 border-b border-gray-200 space-x-2">
                                    <a href="{{ route('admin.reclamations.show', $reclamation) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i> Voir
                                    </a>
                                    @if($reclamation->piece_jointe)
                                    <a href="{{ route('admin.reclamations.download', $reclamation) }}" 
                                       class="text-purple-600 hover:text-purple-900">
                                        <i class="fas fa-download"></i> Pièce jointe
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 px-6 py-3 bg-gray-50 border-t border-gray-200">
                    @if(request('statut'))
                        {{ $reclamations->appends(['statut' => request('statut')])->links() }}
                    @else
                        {{ $reclamations->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection