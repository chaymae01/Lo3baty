@extends('layouts.partenaire')

@section('content')
<main class="flex-1 p-8 overflow-y-auto bg-gray-50 space-y-10">

    {{-- 💬 Nouvelle Évaluation --}}
    <section class="max-w-6xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">
        <h1 class="text-3xl font-extrabold text-indigo-700">💬 Mes Évaluations sur les Clients</h1>

        @if (session('ok'))
            <div class="p-3 bg-green-100 text-green-800 rounded shadow-sm">{{ session('ok') }}</div>
        @elseif (session('error'))
            <div class="p-3 bg-red-100 text-red-800 rounded shadow-sm">{{ session('error') }}</div>
        @endif

        @if ($reservations->isEmpty())
            <div class="bg-yellow-50 text-yellow-800 p-4 rounded shadow text-sm">
                Aucune réservation terminée à évaluer pour le moment.
            </div>
        @else
            <div class="space-y-4">
                <h2 class="text-xl font-bold text-indigo-700">🆕 Laisser une nouvelle évaluation</h2>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($reservations as $res)
                        <div class="bg-white border border-gray-200 p-4 rounded-xl shadow-sm flex flex-col justify-between space-y-3">
                            <div class="space-y-1">
                                <p class="text-base font-semibold text-gray-800">{{ $res->client->prenom }} {{ $res->client->nom }}</p>
                                <p class="text-sm text-gray-600">
                                    🧸 Objet : {{ $res->annonce->objet->nom ?? 'Objet supprimé' }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    📅 Fin : {{ \Carbon\Carbon::parse($res->date_fin)->format('d/m/Y') }}
                                </p>
                            </div>
                            <a href="{{ route('partenaire.evaluations.create', $res->id) }}"
                               class="text-center bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm font-medium transition">
                                ✍️ Évaluer
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>

    {{-- ✅ Historique des évaluations --}}
    <section class="max-w-6xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">
        <h2 class="text-2xl font-bold text-indigo-700">📋 Historique des évaluations</h2>

        @if ($evaluations->isEmpty())
            <p class="text-gray-500 text-sm">Aucune évaluation faite pour le moment.</p>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($evaluations as $eval)
                    <div class="border border-gray-200 p-4 rounded-lg shadow-sm space-y-2 bg-gray-50">
                        <p class="text-base font-semibold text-gray-800">
                            {{ $eval->client->prenom }} {{ $eval->client->nom }}
                        </p>
                        <p class="text-yellow-500 text-sm font-medium">⭐ {{ $eval->note }} / 5</p>
                        @if ($eval->commentaire)
                            <p class="text-sm text-gray-700 italic">"{{ $eval->commentaire }}"</p>
                        @endif
                        <p class="text-xs text-gray-400 mt-1">
                            🕐 {{ $eval->created_at?->format('d/m/Y H:i') ?? 'Date inconnue' }}
                        </p>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
</main>
@endsection
