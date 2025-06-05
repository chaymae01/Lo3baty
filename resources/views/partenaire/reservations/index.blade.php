@extends('layouts.partenaire')

@section('content')
<main class="flex-1 p-8 overflow-y-auto bg-gray-50">
    <div class="max-w-7xl mx-auto space-y-6">

        <h1 class="text-3xl font-extrabold text-indigo-700">🗓 Réservations en attente</h1>

        @if (session('ok'))
            <div class="p-3 bg-green-100 text-green-800 rounded shadow-sm">
                {{ session('ok') }}
            </div>
        @endif

        @if ($reservations->isEmpty())
            <p class="text-gray-500 text-lg">Aucune réservation en attente.</p>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($reservations as $r)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 flex flex-col">
                        <!-- Image -->
                        <img src="{{ $r->annonce->objet->images->first()
                            ? asset('storage/' . $r->annonce->objet->images->first()->url)
                            : 'https://via.placeholder.com/400x250?text=Aucune+image' }}"
                            alt="Image de {{ $r->annonce->objet->nom }}"
                            class="w-full h-40 object-cover">

                        <!-- Infos -->
                        <div class="p-4 space-y-2 flex-1 flex flex-col justify-between">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-800">{{ $r->annonce->objet->nom }}</h2>
                                <p class="text-sm text-gray-600">👤 Client : {{ $r->client->prenom }} {{ $r->client->nom }}</p>
                                <p class="text-sm text-gray-600">📅 Du {{ $r->date_debut->format('d/m/Y') }} au {{ $r->date_fin->format('d/m/Y') }}</p>

                                @php
                                    $start = $r->date_debut;
                                    $end = $r->date_fin;
                                    $days = $start->diffInDays($end) + 1;
                                    $price = $r->annonce->prix_journalier;
                                    $total = $days * $price;
                                @endphp

                                <p class="text-sm text-indigo-700 font-medium">
                                    💰 Total : {{ number_format($total, 2) }} MAD ({{ $days }} jour{{ $days > 1 ? 's' : '' }})
                                </p>

                                <p class="text-xs text-gray-400">🕐 Demandée le {{ $r->created_at->format('d/m/Y H:i') }}</p>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2 pt-4">
                                <form method="POST" action="{{ route('partenaire.reservations.valider', $r) }}">
                                    @csrf
                                    <button class="w-full bg-green-600 text-white px-3 py-2 rounded text-sm hover:bg-green-700 transition">
                                        ✅ Valider
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('partenaire.reservations.refuser', $r) }}">
                                    @csrf
                                    <button class="w-full bg-red-600 text-white px-3 py-2 rounded text-sm hover:bg-red-700 transition">
                                        ❌ Refuser
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</main>
@endsection
