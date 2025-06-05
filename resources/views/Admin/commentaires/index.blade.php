@extends('admin.layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50">

    <!-- Sidebar fixe -->
    <div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar fixe à gauche -->
    <div class="w-64 fixed top-0 left-0 bottom-0 bg-white shadow-md z-10">
        @include('admin.layouts.sidebar')
    </div>

    <!-- Contenu principal avec marge pour la sidebar -->
    <div class="flex-1 p-8 space-y-10 ml-64"> <!-- Ajustez ml-64 selon la largeur de votre sidebar -->
    
    <h1 class="text-2xl font-bold mb-6">Gestion des Commentaires</h1>
    

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form action="{{ route('admin.commentaires') }}" method="GET" class="flex flex-wrap gap-4">
            <div>
                <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
                <select name="statut" id="statut" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                    <option value="">Tous</option>
                    <option value="signale" {{ request('statut') === 'signale' ? 'selected' : '' }}>🚩 Signalé</option>
                    <option value="publie" {{ request('statut') === 'publie' ? 'selected' : '' }}>✅ Publié</option>
                </select>
            </div>
            
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                <select name="type" id="type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                    <option value="">Tous</option>
                    <option value="client_partenaire" {{ request('type') === 'client_partenaire' ? 'selected' : '' }}>Partenaire → Client </option>
                    <option value="partenaire_client" {{ request('type') === 'partenaire_client' ? 'selected' : '' }}>Client → Partenaire</option>
                    <option value="annonce" {{ request('type') === 'annonce' ? 'selected' : '' }}>Évaluation d'annonce</option>
                </select>
            </div>
            
            <div class="self-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Filtrer
                </button>
                <a href="{{ route('admin.commentaires') }}" class="ml-2 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Réinitialiser
                </a>
            </div>
        </form>
    </div>

    <!-- Tableau des commentaires -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Auteur</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cible</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commentaire</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($commentaires as $commentaire)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $commentaire->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    @if($commentaire->client)
                                        {{ $commentaire->client->surnom }}
                                        <div class="text-xs text-gray-500">(Client)</div>
                                    @elseif($commentaire->partner)
                                        {{ $commentaire->partner->surnom }}
                                        <div class="text-xs text-gray-500">(Partenaire)</div>
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    @if($commentaire instanceof \App\Models\Admin\EvaluationOnClients)
                                        @if($commentaire->partner)
                                            {{ $commentaire->partner->surnom }}
                                            <div class="text-xs text-gray-500">(Partenaire)</div>
                                        @endif
                                    @elseif($commentaire instanceof \App\Models\Admin\EvaluationOnPartners)
                                        @if($commentaire->client)
                                            {{ $commentaire->client->surnom }}
                                            <div class="text-xs text-gray-500">(Client)</div>
                                        @endif
                                    @elseif($commentaire instanceof \App\Models\Admin\EvaluationOnAnnonces)
                                        @if($commentaire->objet)
                                            {{ $commentaire->objet->nom }}
                                            <div class="text-xs text-gray-500">(Annonce)</div>
                                        @endif
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($commentaire instanceof \App\Models\Admin\EvaluationOnClients)
                                     Partenaire → Client
                                @elseif($commentaire instanceof \App\Models\Admin\EvaluationOnPartners)
                                    Client → Partenaire
                                @else
                                    Évaluation d'annonce 
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $commentaire->note)
                                                ⭐
                                            @else
                                                <span class="text-gray-300">☆</span>
                                            @endif
                                        @endfor
                                    </span>
                                    <span class="ml-1 text-sm text-gray-500">({{ $commentaire->note }}/5)</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <div class="group relative">
                                    <span class="cursor-pointer hover:text-blue-500">
                                        {{ Str::limit($commentaire->commentaire, 50) }}
                                    </span>
                                    @if(strlen($commentaire->commentaire) > 50)
                                        <div class="absolute hidden group-hover:block z-10 w-64 p-2 mt-1 text-sm bg-white border rounded shadow-lg">
                                            {{ $commentaire->commentaire }}
                                        </div>
                                    @endif
                                </div>
                                @if($commentaire->flag_reason)
                                    <div class="text-xs text-red-500 mt-1">
                                        <strong>Raison:</strong> {{ $commentaire->flag_reason }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($commentaire->is_flagged)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        🚩 Signalé
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        ✅ Publié
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
    <div class="flex items-center space-x-2">
        <!-- Bouton Voir : redirige vers la page de détail du commentaire -->
        <a href="{{ route('admin.commentaires.show', $commentaire->id) }}" 
           class="px-3 py-1 bg-blue-100 text-blue-800 rounded hover:bg-blue-200">
            Voir
        </a>

        <!-- Si le commentaire est signalé, afficher le bouton de validation -->
        @if($commentaire->is_flagged)
            <!-- Bouton Valider : approuve un commentaire signalé -->
            <form action="{{ route('admin.commentaires.approve', $commentaire->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-3 py-1 bg-green-100 text-green-800 rounded hover:bg-green-200">
                    Valider
                </button>
            </form>
        @else
            <!-- 
            Bouton Rejeter (commenté) : prévu pour refuser un commentaire non signalé 
            <form action="{{ route('admin.commentaires.destroy', $commentaire->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded hover:bg-yellow-200">
                    Rejeter
                </button>
            </form> 
            -->
        @endif

        <!-- Bouton Supprimer : suppression définitive du commentaire -->
        <form action="{{ route('admin.commentaires.destroy', $commentaire->id) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-3 py-1 bg-red-100 text-red-800 rounded hover:bg-red-200">
                Supprimer
            </button>
        </form>
    </div>
</td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">Aucun commentaire trouvé</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (window.lucide) {
            lucide.createIcons();
        } else {
            console.error("Lucide Icons n'est pas chargé !");
        }
    });
</script>
@endpush

@push('styles')
<style>
    .group:hover .group-hover\:block {
        display: block;
    }
    tr:hover {
        background-color: #f9fafb;
    }
    .transition-colors {
        transition: color 0.2s, background-color 0.2s;
    }
</style>
@endpush