@extends('layouts.partenaire')

@section('content')
<main class="flex-1 p-8 overflow-y-auto bg-gray-50">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow space-y-6">
        <h1 class="text-2xl font-bold text-indigo-700 mb-4">
            ✍️ Évaluer le client (Réservation ID : {{ $reservation->id }})
        </h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('partenaire.evaluations.store') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Note (1 à 5)</label>
                <select name="note" class="w-full border rounded px-3 py-2">
                    <option value="">-- Choisir --</option>
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }} ⭐</option>
                    @endfor
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Commentaire (optionnel)</label>
                <textarea name="commentaire" class="w-full border rounded px-3 py-2" rows="4"></textarea>
            </div>

            <button class="bg-indigo-600 text-white px-6 py-2 rounded shadow hover:bg-indigo-700 transition">
                ✅ Soumettre l'évaluation
            </button>
        </form>
    </div>
</main>
@endsection
