@extends('layouts.partenaire')

@section('content')
<main class="flex-1 p-8 overflow-y-auto bg-gray-50">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">
        <h1 class="text-2xl font-bold text-indigo-700 mb-6">👤 Modifier mon profil</h1>

        {{-- 🛎️ Messages --}}
        @if (session('ok'))
            <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('ok') }}</div>
        @elseif (session('error'))
            <div class="p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif

        {{-- 📝 Form --}}
        <form method="POST" action="{{ route('partenaire.profil.update') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Nom --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                <input type="text" name="nom" value="{{ old('nom', $user->nom) }}"
                       class="w-full border rounded px-3 py-2 @error('nom') border-red-500 @enderror">
                @error('nom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Prénom --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                <input type="text" name="prenom" value="{{ old('prenom', $user->prenom) }}"
                       class="w-full border rounded px-3 py-2 @error('prenom') border-red-500 @enderror">
                @error('prenom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Surnom --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Surnom</label>
                <input type="text" name="surnom" value="{{ old('surnom', $user->surnom) }}"
                       class="w-full border rounded px-3 py-2 @error('surnom') border-red-500 @enderror">
                @error('surnom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Email (readonly) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Adresse e-mail</label>
                <input type="email" value="{{ $user->email }}" disabled
                       class="w-full border rounded px-3 py-2 bg-gray-100 text-gray-500 cursor-not-allowed">
            </div>

            {{-- Mot de passe --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe (facultatif)</label>
                <input type="password" name="mot_de_passe"
                       class="w-full border rounded px-3 py-2 @error('mot_de_passe') border-red-500 @enderror"
                       placeholder="Laissez vide pour conserver l'actuel">
                @error('mot_de_passe') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Image de profil --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Image de profil</label>

                <div class="flex items-center space-x-4">
                    <img src="{{ $user->image_profil }}" alt="Profil actuel" class="w-20 h-20 object-cover rounded-full border">
                    <input type="file" name="image_profil" accept="image/*"
                           class="text-sm text-gray-600">
                </div>

                @error('image_profil') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- CIN --}}
            <div class="grid sm:grid-cols-2 gap-4">
                {{-- CIN Recto --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">CIN (Recto)</label>
                    @if ($user->cin_recto)
                        <img src="{{ asset('storage/' . $user->cin_recto) }}" alt="CIN Recto" class="w-full rounded border mb-2">
                    @endif
                    <input type="file" name="cin_recto" accept="image/*" class="text-sm text-gray-600">
                    @error('cin_recto') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- CIN Verso --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">CIN (Verso)</label>
                    @if ($user->cin_verso)
                        <img src="{{ asset('storage/' . $user->cin_verso) }}" alt="CIN Verso" class="w-full rounded border mb-2">
                    @endif
                    <input type="file" name="cin_verso" accept="image/*" class="text-sm text-gray-600">
                    @error('cin_verso') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- ✅ Submit --}}
            <button type="submit"
                    class="mt-4 bg-indigo-600 text-white px-6 py-2 rounded shadow hover:bg-indigo-700 transition">
                💾 Enregistrer les modifications
            </button>
        </form>
    </div>
</main>
@endsection
