@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Paramètres de votre compte</h1>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    <!-- Bouton pour ouvrir le modal -->
    <button @click="open = true" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
        Modifier mes informations
    </button>

    <!-- Modal (Alpine.js requis) -->
    <div x-data="{ open: false }">
        <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded-lg w-full max-w-lg shadow-xl relative">
                <button @click="open = false" class="absolute top-2 right-2 text-gray-600 hover:text-black">&times;</button>
                <h2 class="text-xl font-semibold mb-4">Modifier mes informations</h2>
                
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block mb-1 font-medium">Nom</label>
                        <input type="text" name="nom" value="{{ old('nom', Auth::user()->nom) }}" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Prénom</label>
                        <input type="text" name="prenom" value="{{ old('prenom', Auth::user()->prenom) }}" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Surnom</label>
                        <input type="text" name="surnom" value="{{ old('surnom', Auth::user()->surnom) }}" class="w-full border rounded px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Photo de profil</label>
                        @if(Auth::user()->image_profil)
                            <img src="{{ asset('storage/' . Auth::user()->image_profil) }}" alt="Profil" class="w-20 h-20 object-cover rounded-full mb-2">
                        @endif
                        <input type="file" name="image_profil" class="w-full border rounded px-3 py-2">
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="//unpkg.com/alpinejs" defer></script>
@endsection
