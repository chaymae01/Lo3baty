@extends('layouts.partenaire')

@section('content')
<main id="dashboard-content" class="flex-1 p-8 overflow-y-auto">
    <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow text-center">

        <div class="text-red-600 mb-4">
            @include('components.icons.cross') {{-- icône "croix" --}}
        </div>

        <h1 class="text-2xl font-bold text-red-600 mb-4">
            Limite d’annonces atteinte
        </h1>

        <p class="text-gray-700 mb-6">
            Vous avez déjà <span class="font-semibold">{{ $activeCount }}</span> annonces actives.
            La limite est fixée à 5 annonces par partenaire.
        </p>

        <a href="{{ route('partenaire.dashboard') }}"
           class="inline-block bg-red-600 text-white px-6 py-2 rounded shadow hover:bg-red-700 transition">
            ↩️ Retour au dashboard
        </a>
    </div>
</main>
@endsection
