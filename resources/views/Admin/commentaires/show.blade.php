@extends('admin.layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar fixe à gauche -->
    <div class="w-64 fixed top-0 left-0 bottom-0 bg-white shadow-md z-10">
        @include('admin.layouts.sidebar')
    </div>

    <!-- Contenu principal - décalé de la largeur de la sidebar -->
    <div class="flex-1 ml-64 p-8 space-y-10">
        {{-- Titre --}}
        <h1 class="text-2xl font-bold mb-6">Détail du Commentaire</h1>

        {{-- Carte du commentaire --}}
        <div class="bg-white shadow-xl rounded-2xl p-8 max-w-4xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700 text-lg">

                {{-- ID --}}
                <div>
                    <p class="flex items-center font-medium gap-2 mb-1">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18" />
                        </svg>
                        ID :
                    </p>
                    <p class="bg-gray-50 p-3 rounded-lg">{{ $commentaire->id }}</p>
                </div>

              <!-- Auteur -->
<div>
    <p class="flex items-center font-medium gap-2 mb-1">
        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A4 4 0 0112 21a4 4 0 016.879-3.196M15 11a4 4 0 10-8 0 4 4 0 008 0z" />
        </svg>
        Auteur :
    </p>
    <p class="bg-gray-50 p-3 rounded-lg">
        @if($commentaire->client)
            {{ $commentaire->client->surnom }} (Client)
        @elseif($commentaire->partner)
            {{ $commentaire->partner->surnom }} (Partenaire)
        @else
            N/A
        @endif
    </p>
</div>

<!-- Destinataire -->
<div>
    <p class="flex items-center font-medium gap-2 mb-1">
        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20h6M4 20h5M12 4a4 4 0 00-4 4v1a2 2 0 01-2 2H5a4 4 0 014-4h.001A4 4 0 0012 4z" />
        </svg>
        Destinataire :
    </p>
    <p class="bg-gray-50 p-3 rounded-lg">
        @if($commentaire instanceof \App\Models\Admin\EvaluationOnClients)
            @if($commentaire->partner)
                {{ $commentaire->partner->surnom }} (Partenaire)
            @endif
        @elseif($commentaire instanceof \App\Models\Admin\EvaluationOnPartners)
            @if($commentaire->client)
                {{ $commentaire->client->surnom }} (Client)
            @endif
        @elseif($commentaire instanceof \App\Models\Admin\EvaluationOnAnnonces)
            @if($commentaire->objet)
                {{ $commentaire->objet->nom }} (Annonce)
            @endif
        @endif
    </p>
</div>


                {{-- Note --}}
                <div>
                    <p class="flex items-center font-medium gap-2 mb-1">
                        <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.334 4.09a1 1 0 00.95.69h4.313c.969 0 1.371 1.24.588 1.81l-3.49 2.541a1 1 0 00-.364 1.118l1.334 4.09c.3.921-.755 1.688-1.54 1.118l-3.49-2.541a1 1 0 00-1.176 0l-3.49 2.541c-.784.57-1.838-.197-1.539-1.118l1.334-4.09a1 1 0 00-.364-1.118L2.175 9.517c-.783-.57-.38-1.81.588-1.81h4.313a1 1 0 00.95-.69l1.334-4.09z" />
                        </svg>
                        Note :
                    </p>
                    <p class="bg-gray-50 p-3 rounded-lg">{{ $commentaire->note }}</p>
                </div>

                {{-- Commentaire --}}
                <div class="md:col-span-2">
                    <p class="flex items-center font-medium gap-2 mb-1">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Commentaire :
                    </p>
                    <p class="bg-gray-50 p-3 rounded-lg">{{ $commentaire->commentaire }}</p>
                </div>

                {{-- Statut --}}
                
<div class="md:col-span-2"> <!-- J'ai ajouté md:col-span-2 pour plus de largeur -->
    <p class="flex items-center font-medium gap-2 mb-1">
        <svg class="w-5 h-5 {{ $commentaire->is_flagged ? 'text-red-500' : 'text-green-500' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6h13l-3 4 3 4H9z" />
        </svg>
        Statut :
    </p>
    <p class="inline-block px-4 py-1 rounded-full text-white text-sm font-semibold 
        {{ $commentaire->is_flagged ? 'bg-red-500' : 'bg-green-500' }} mb-2">
        {{ $commentaire->is_flagged ? '🚩 Signalé' : '✅ Publié' }}
    </p>
    
    {{-- Ajoutez ce bloc pour afficher la raison --}}
    @if($commentaire->is_flagged && $commentaire->flag_reason)
        <div class="mt-2 p-3 bg-red-50 rounded-lg border border-red-100">
            <p class="text-sm font-medium text-red-800">Raison du signalement :</p>
            <p class="text-red-600">{{ $commentaire->flag_reason }}</p>
        </div>
    @endif
</div>

            {{-- Actions --}}
            <div class="mt-8 flex justify-between items-center">
                <a href="{{ route('admin.commentaires') }}"
                   class="inline-flex items-center gap-2 px-5 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Retour à la liste
                </a>

                <form method="POST" action="{{ route('admin.commentaires.destroy', $commentaire->id) }}">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Supprimer ce commentaire ?')"
            class="inline-flex items-center gap-2 px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
        Supprimer
    </button>
</form>
            </div>
        </div>
    </div>
</div>
@endsection
