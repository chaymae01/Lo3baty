@extends('admin.layouts.app')

@section('title', 'Détails Réservation')

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
        <h1 class="text-2xl font-bold">Réservation #{{ $reservation->id }}</h1>
        <a href="{{ route('admin.reservations.index') }}" class="text-blue-600 hover:text-blue-900">
            ← Retour
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h2 class="text-lg font-semibold mb-2">Informations</h2>
                <p><span class="font-medium">Statut:</span>
                    <span class="px-2 py-1 text-xs rounded-full {{ $reservation->statut_couleur }}">
                        {{ ucfirst(str_replace('_', ' ', $reservation->statut)) }}
                    </span>
                </p>
                <p><span class="font-medium">Période:</span>
                    {{ $reservation->date_debut->format('d/m/Y') }} au {{ $reservation->date_fin->format('d/m/Y') }}
                </p>
            </div>
            <div>
                <h2 class="text-lg font-semibold mb-2">Client</h2>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="font-medium">{{ $reservation->client->name ?? 'Client inconnu' }}</p>
                    <p class="text-sm text-gray-600 mt-1">{{ $reservation->client->email ?? '' }}</p>
                </div>
            </div>
        </div>
       
        <div class="mt-6">
            <h2 class="text-lg font-semibold mb-2">Annonce réservée</h2>
            <div class="bg-gray-50 p-4 rounded-lg">
                @if($reservation->annonce)
                    <p class="font-medium">{{ $reservation->annonce->id }}</p>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ $reservation->annonce->prix_journalier }} €/jour
                    </p>
                @else
                    <p class="text-red-500">Annonce supprimée</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection