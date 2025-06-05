@extends('layouts.partenaire')

@section('content')
<main id="dashboard-content" class="flex-1 p-8 overflow-y-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Bienvenue dans votre espace partenaire</h1>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        {{-- Réservations en attente --}}
        <div class="bg-white rounded-2xl shadow-md border-l-4 border-yellow-500 p-6 hover:shadow-lg transition">
            <div class="flex items-center gap-3 mb-2">
                <i class="fas fa-clock text-yellow-500 text-2xl"></i>
                <h2 class="text-xl font-semibold text-gray-800">Réservations en attente</h2>
            </div>
            <p class="text-3xl font-bold text-yellow-600">{{ $reservationsStats->en_attente ?? 0 }}</p>
        </div>

        {{-- Réservations confirmées --}}
        <div class="bg-white rounded-2xl shadow-md border-l-4 border-green-500 p-6 hover:shadow-lg transition">
            <div class="flex items-center gap-3 mb-2">
                <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                <h2 class="text-xl font-semibold text-gray-800">Réservations confirmées</h2>
            </div>
            <p class="text-3xl font-bold text-green-600">{{ $reservationsStats->valide ?? 0 }}</p>
        </div>

        {{-- Réservations annulées --}}
        <div class="bg-white rounded-2xl shadow-md border-l-4 border-red-500 p-6 hover:shadow-lg transition">
            <div class="flex items-center gap-3 mb-2">
                <i class="fas fa-times-circle text-red-500 text-2xl"></i>
                <h2 class="text-xl font-semibold text-gray-800">Réservations annulées</h2>
            </div>
            <p class="text-3xl font-bold text-red-600">{{ $reservationsStats->refuse ?? 0 }}</p>
        </div>

        {{-- Annonces actives --}}
        <div class="bg-white rounded-2xl shadow-md border-l-4 border-indigo-500 p-6 hover:shadow-lg transition">
            <div class="flex items-center gap-3 mb-2">
                <i class="fas fa-bullhorn text-indigo-500 text-2xl"></i>
                <h2 class="text-xl font-semibold text-gray-800">Annonces actives</h2>
            </div>
            <p class="text-3xl font-bold text-indigo-600">{{ $annoncesStats->actives ?? 0 }}</p>
        </div>

        {{-- Annonces archivées --}}
        <div class="bg-white rounded-2xl shadow-md border-l-4 border-gray-500 p-6 hover:shadow-lg transition">
            <div class="flex items-center gap-3 mb-2">
                <i class="fas fa-archive text-gray-500 text-2xl"></i>
                <h2 class="text-xl font-semibold text-gray-800">Annonces archivées</h2>
            </div>
            <p class="text-3xl font-bold text-gray-700">{{ $annoncesStats->archivees ?? 0 }}</p>
        </div>

        {{-- Produits (Objets) --}}
        <div class="bg-white rounded-2xl shadow-md border-l-4 border-purple-500 p-6 hover:shadow-lg transition">
            <div class="flex items-center gap-3 mb-2">
                <i class="fas fa-boxes text-purple-500 text-2xl"></i>
                <h2 class="text-xl font-semibold text-gray-800">Produits</h2>
            </div>
            <p class="text-3xl font-bold text-purple-600">{{ $totalProduits }}</p>
        </div>
    </div>
</main>
@endsection
