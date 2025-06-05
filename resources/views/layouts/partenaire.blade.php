<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Partenaire</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Vite CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<script src="//unpkg.com/alpinejs" defer></script>

<body class="bg-gray-100 text-gray-800">
<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg p-6 space-y-6 hidden lg:block sticky top-0 h-screen overflow-y-auto">
        @php
            // Forcer l'affichage de l'utilisateur ID 1
            $partnerId = auth()->id() ?? 1;
            $profil = \App\Models\Utilisateur::find($partnerId);
            $avgRating = \App\Models\EvaluationOnPartner::where('partner_id', $partnerId)->avg('note');

        @endphp
    
        <div class="text-center">
            <img src="{{ $profil && $profil->image_profil ? $profil->image_profil : asset('storage/images/profile.jpeg') }}"
                class="w-20 h-20 mx-auto rounded-full shadow mb-2 object-cover"
                alt="Photo de profil">
            <h2 class="text-xl font-bold text-indigo-700">
                {{ $profil ? $profil->prenom : 'Mohamed' }} {{ $profil ? $profil->nom : 'Bens' }}
            </h2>
            <p class="text-gray-500 text-sm">{{ $profil ? $profil->email : 'test@gmail.com' }}</p>

            @if($avgRating)
                <div class="mt-2 text-yellow-500 text-sm">
                    ⭐ {{ number_format($avgRating, 1) }} / 5
                </div>
            @else
                <div class="mt-2 text-gray-400 text-sm">
                    ⭐ Aucune évaluation
                </div>
            @endif
        </div>
        <nav class="space-y-4 mt-6">

            <!-- Dash -->
            <a href="{{ route('partenaire.dashboard') }}" 
                class="flex items-center gap-3 text-gray-700 hover:bg-gray-100 p-2 rounded transition">
                <i class="fas fa-table-columns text-indigo-500 w-5 text-center"></i>
                <span>Dashboard</span>
            </a>

            <!-- Profil -->
            <a href="{{ route('partenaire.profil.edit') }}"
                class="flex items-center gap-3 text-gray-700 hover:bg-gray-100 p-2 rounded transition">
                <i class="fas fa-user text-indigo-500 w-5 text-center"></i>
                <span>Profil</span>
            </a>

            <!-- Produits -->
            <a href="{{ route('partenaire.products.index') }}"
               class="flex items-center gap-3 p-2 hover:bg-gray-100 rounded text-gray-700">
                <i class="fas fa-cube text-indigo-500 w-5 text-center"></i>
                <span>Mes Produits</span>
            </a>

            <!-- Créer une Annonce -->
            <a href="{{ route('partenaire.annonces.choose') }}"
                class="flex items-center gap-3 p-2 hover:bg-gray-100 rounded text-gray-700 transition">
                <i class="fas fa-plus-circle text-indigo-500 w-5 text-center"></i>
                <span>Créer une Annonce</span>
            </a>

            <!-- Gérer les Annonces -->
            <a href="{{ route('partenaire.annonces.index') }}"
               class="flex items-center gap-3 p-2 hover:bg-gray-100 rounded text-gray-700 transition">
                <i class="fas fa-bullhorn text-indigo-500 w-5 text-center"></i>
                <span>Gérer les Annonces</span>
            </a>

            <!-- Réservations -->
            <a href="{{ route('partenaire.reservations.index') }}"
               class="flex items-center gap-3 p-2 hover:bg-gray-100 rounded text-gray-700 transition">
                <i class="fas fa-calendar-check text-indigo-500 w-5 text-center"></i>
                <span>Gérer les Réservations</span>
            </a>

            <a href="{{ route('partenaire.evaluations.index') }}"
                class="flex items-center gap-3 p-2 hover:bg-gray-100 rounded text-gray-700 transition">
                    <i class="fas fa-star text-indigo-500 w-5 text-center"></i>
                    <span>Mes Évaluations</span>
            </a>

            <a href="{{ route('partenaire.evaluations.commentaires') }}" 
                class="flex items-center gap-3 p-2 hover:bg-gray-100 rounded text-gray-700 transition">
                    <i class="fas fa-comments text-indigo-500 w-5 text-center"></i>
                Commentaires
            </a>

            <div class="mt-6 border-t pt-4">
                <div class="flex border rounded overflow-hidden">
                    {{-- Active Partenaire tab --}}
                    <button class="flex-1 py-2 text-sm font-semibold text-indigo-600 bg-indigo-50 border-r border-indigo-200">
                        <i class="fas fa-user-tie mr-1"></i>Partenaire
                    </button>

                    {{-- Client tab triggers role switch --}}
                    <form action="{{ route('partenaire.switch.to.client') }}" method="POST" class="flex-1 text-center">
                        @csrf
                        <button type="submit" class="w-full py-2 text-sm text-gray-600 bg-white hover:bg-gray-100">
                            <i class="fas fa-user mr-1"></i>Client
                        </button>
                    </form>
                </div>
            </div>
        </nav>
    </aside>

    <!-- Content -->
    <main class="flex-1 p-6">
        @yield('content')
    </main>
</div>
</body>
</html>
