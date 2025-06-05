@extends('admin.layouts.app')

@section('title', 'Détails Annonce')

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
        <h1 class="text-2xl font-bold">Détails de l'annonce #{{ $annonce->id }}</h1>
        <a href="{{ route('admin.annonces.index') }}" class="text-blue-600 hover:text-blue-900">
            ← Retour
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h2 class="text-lg font-semibold mb-2">Informations de base</h2>
                <p>
                    <span class="font-medium">Statut:</span> 
                    <span class="px-2 py-1 text-xs rounded-full 
                        {{ $annonce->statut === 'active' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                        {{ ucfirst($annonce->statut) }}
                    </span>
                </p>
                <p><span class="font-medium">Prix journalier:</span> {{ number_format($annonce->prix_journalier, 2) }} €</p>
                <p><span class="font-medium">Adresse:</span> {{ $annonce->adresse }}</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold mb-2">Dates</h2>
                <p><span class="font-medium">Publication:</span> {{ $annonce->date_publication->format('d/m/Y') }}</p>
                <p><span class="font-medium">Disponibilité:</span> 
                    {{ $annonce->date_debut->format('d/m/Y') }} - {{ $annonce->date_fin->format('d/m/Y') }}
                </p>
                @if($annonce->premium)
                <p><span class="font-medium">Premium:</span> 
                    {{ $annonce->premium_periode }} jours (début: {{ $annonce->premium_start_date->format('d/m/Y') }})
                </p>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-semibold mb-2">Objet</h2>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="font-medium">{{ $annonce->objet->nom ?? 'Non spécifié' }}</p>
                    <p class="text-sm text-gray-600 mt-1">{{ $annonce->objet->description ?? '' }}</p>
                </div>
            </div>
            <div>
                <h2 class="text-lg font-semibold mb-2">Partenaire (DEBUG)</h2>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="font-medium">ID Partenaire: {{ $annonce->partenaire_id }}</p>
                    <p class="font-medium">Nom: {{ $annonce->partenaire ? $annonce->partenaire->name : 'NULL' }}</p>
                    <p class="text-sm text-gray-600 mt-1">Email: {{ $annonce->partenaire->email ?? 'NULL' }}</p>
                    @if($annonce->partenaire)
                        <p class="text-sm text-gray-600 mt-1">Type: {{ get_class($annonce->partenaire) }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection