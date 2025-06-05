@extends('admin.layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar fixe à gauche -->
    <div class="w-64 fixed top-0 left-0 bottom-0 bg-white shadow-md z-10">
        @include('admin.layouts.sidebar')
    </div>

    <!-- Contenu principal à droite avec une marge à gauche pour la sidebar -->
    <div class="flex-1 ml-64 p-8 space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Gestion des Paiements</h1>
            <div class="flex space-x-3">
            <a href="{{ route('admin.paiements.export', array_merge(request()->query(), ['type' => 'clients'])) }}"
   class="btn btn-primary">
    <i data-lucide="download" class="w-4 h-4 mr-2"></i> Exporter Clients
</a>
<a href="{{ route('admin.paiements.export', array_merge(request()->query(), ['type' => 'partenaires'])) }}"
   class="btn btn-secondary">
    <i data-lucide="download" class="w-4 h-4 mr-2"></i> Exporter Partenaires
</a>
            </div>
        </div>

        @include('admin.paiements.partials._stats')
        @include('admin.paiements.partials._filters')

        <!-- Section des tables -->
        <div class="space-y-8">
            <!-- Tableau Clients - Conditionnellement visible -->
            @if(!request()->has('type') || request('type') === 'clients')
                @include('admin.paiements.partials._client_table')
            @endif

            <!-- Tableau Partenaires - Conditionnellement visible -->
            @if(!request()->has('type') || request('type') === 'partenaires')
                @include('admin.paiements.partials._partner_table')
            @endif
            
            <!-- Message si aucun résultat -->
            @if((request()->has('type') && $paiementsClients->isEmpty() && $paiementsPartenaires->isEmpty()))
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-gray-500">Aucun résultat trouvé pour les critères de recherche sélectionnés.</p>
                    <a href="{{ route('admin.paiements') }}" class="btn btn-primary mt-4">
                        <i data-lucide="refresh-ccw" class="w-4 h-4 mr-2"></i> Réinitialiser les filtres
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
