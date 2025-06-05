@extends('admin.layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar fixe à gauche -->
    <div class="w-64 fixed top-0 left-0 bottom-0 bg-white shadow-md z-10">
        @include('admin.layouts.sidebar')
    </div>

    <!-- Contenu principal avec marge pour la sidebar -->
    <div class="flex-1 p-8 space-y-10 ml-64"> <!-- Ajustez ml-64 selon la largeur de votre sidebar -->
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Réclamation #{{ $reclamation->id }}</h1>
        <a href="{{ route('admin.reclamations.index') }}" 
           class="text-blue-600 hover:text-blue-900">
            ← Retour à la liste
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h2 class="text-lg font-semibold mb-2">Informations</h2>
                <p><span class="font-medium">Utilisateur:</span> {{ $reclamation->utilisateur->name ?? 'Utilisateur supprimé' }}</p>
                <p><span class="font-medium">Date:</span> {{ $reclamation->created_at->format('d/m/Y H:i') }}</p>
                <p><span class="font-medium">Statut:</span> 
                    @php
                        $statusClasses = [
                            'en attente' => 'bg-yellow-100 text-yellow-800',
                            'resolue' => 'bg-green-100 text-green-800',
                        ];
                        $statut = strtolower($reclamation->statut);
                    @endphp
                    <span class="px-2 py-1 text-xs rounded-full {{ $statusClasses[$statut] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $reclamation->statut }}
                    </span>
                </p>
            </div>
            <div>
                <h2 class="text-lg font-semibold mb-2">Détails</h2>
                <p><span class="font-medium">Sujet:</span> {{ $reclamation->sujet }}</p>
                <p class="mt-2"><span class="font-medium">Contenu:</span></p>
                <div class="bg-gray-50 p-3 rounded mt-1">
                    {{ $reclamation->contenu }}
                </div>
            </div>
        </div>

        @if($reclamation->piece_jointe)
        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-2">Pièce jointe</h2>
            <a href="{{ route('admin.reclamations.download', $reclamation) }}" 
               class="text-purple-600 hover:text-purple-900 flex items-center">
                <i class="fas fa-download mr-2"></i>
                Télécharger le fichier joint
            </a>
        </div>
        @endif

        @if($reclamation->reponse)
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <h2 class="text-lg font-semibold mb-2">Réponse actuelle</h2>
            <div class="prose max-w-none">
                {!! nl2br(e($reclamation->reponse)) !!}
            </div>
            <p class="text-sm text-gray-500 mt-2">
    @if($reclamation->date_reponse)
        Répondu le: {{ $reclamation->date_reponse->format('d/m/Y H:i') }}
    @else
        En attente de réponse
    @endif
</p>
        </div>
        @endif

        <form action="{{ route('admin.reclamations.repondre', $reclamation) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="reponse" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $reclamation->reponse ? 'Modifier la réponse' : 'Répondre à la réclamation' }}
                </label>
                <textarea name="reponse" id="reponse" rows="6" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                    required>{{ old('reponse', $reclamation->reponse) }}</textarea>
            </div>
            
            <div class="flex items-center space-x-4">
                <button type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    {{ $reclamation->reponse ? 'Mettre à jour' : 'Envoyer' }}
                </button>
                
                @if($reclamation->reponse)
                <button type="button" onclick="document.getElementById('reponse').value=''" 
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                    Effacer
                </button>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection