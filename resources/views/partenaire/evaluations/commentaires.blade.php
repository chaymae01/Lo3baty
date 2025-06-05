@extends('layouts.partenaire')

@section('content')
<main class="flex-1 p-8 overflow-y-auto bg-gray-50">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">
        <h1 class="text-2xl font-bold text-indigo-700">💬 Commentaires des clients</h1>

        @if (session('ok'))
            <div class="bg-green-100 text-green-800 p-3 rounded">{{ session('ok') }}</div>
        @endif

        @if ($evaluations->isEmpty())
            <p class="text-gray-500">Aucun commentaire pour le moment.</p>
        @else
            <div class="space-y-4">
                @foreach ($evaluations as $eval)
                    <div class="border p-4 rounded-lg shadow-sm space-y-2 
                                {{ $eval->signaler ? 'bg-red-50 border-red-300' : 'bg-white' }}">

                        <div class="flex justify-between items-center">
                            <p class="font-semibold text-gray-800">
                                {{ $eval->client->prenom }} {{ $eval->client->nom }}
                            </p>

                            @if ($eval->signaler)
                                <form method="POST" action="{{ route('partenaire.evaluations.unsignaler', $eval) }}">
                                    @csrf
                                    <button type="submit"
                                            class="text-sm text-gray-600 hover:underline">
                                        <span class="text-xs bg-red-200 text-red-800 px-2 py-1 rounded-full">
                                            🚩 Signalé
                                        </span>
                                    </button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('partenaire.evaluations.signaler', $eval) }}">
                                    @csrf
                                    <button type="submit"
                                            class="text-sm text-red-600 hover:underline">
                                        🚩 Signaler ce commentaire
                                    </button>
                                </form>
                            @endif

                        </div>

                        <p class="text-yellow-500 font-semibold">
                            ⭐ {{ $eval->note }} / 5
                        </p>

                        @if ($eval->commentaire)
                            <p class="text-sm text-gray-700 italic">"{{ $eval->commentaire }}"</p>
                        @endif

                        <p class="text-xs text-gray-400">
                            🕒 {{ $eval->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                @endforeach


            </div>
        @endif
    </div>
</main>
@endsection
