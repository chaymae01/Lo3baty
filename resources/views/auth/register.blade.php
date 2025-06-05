@extends('layouts.app')

@section('title', 'Inscription - Lo3baty') 

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-4">
        <div class="bg-white p-8 rounded-lg shadow-md">
            <!-- Logo Section -->
            <div class="flex justify-center mb-6">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('storage/images/Lo3baty.jpg') }}" 
                         alt="Lo3baty Logo" 
                         class="h-20 w-auto mx-auto hover:opacity-75 transition-opacity duration-200">
                </a>
            </div>

            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900">{{ __('Inscription') }}</h2>
            </div>

            <form class="mt-6 space-y-4" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf

                <div class="space-y-3">
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700">{{ __('Nom') }}</label>
                        <div class="mt-1">
                            <input id="nom" name="nom" type="text" autocomplete="nom" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#e63a28] focus:border-[#e63a28] @error('nom') border-red-500 @enderror"
                                   value="{{ old('nom') }}">
                            @error('nom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="prenom" class="block text-sm font-medium text-gray-700">{{ __('Prénom') }}</label>
                        <div class="mt-1">
                            <input id="prenom" name="prenom" type="text" autocomplete="prenom" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#e63a28] focus:border-[#e63a28] @error('prenom') border-red-500 @enderror"
                                   value="{{ old('prenom') }}">
                            @error('prenom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="surnom" class="block text-sm font-medium text-gray-700">{{ __('Surnom') }}</label>
                        <div class="mt-1">
                            <input id="surnom" name="surnom" type="text" autocomplete="surnom" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#e63a28] focus:border-[#e63a28] @error('surnom') border-red-500 @enderror"
                                   value="{{ old('surnom') }}">
                            @error('surnom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" autocomplete="email" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#e63a28] focus:border-[#e63a28] @error('email') border-red-500 @enderror"
                                   value="{{ old('email') }}">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="mot_de_passe" class="block text-sm font-medium text-gray-700">{{ __('Mot de passe') }}</label>
                        <div class="mt-1">
                            <input id="mot_de_passe" name="mot_de_passe" type="password" autocomplete="new-password" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#e63a28] focus:border-[#e63a28] @error('mot_de_passe') border-red-500 @enderror">
                            @error('mot_de_passe')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="mot_de_passe-confirm" class="block text-sm font-medium text-gray-700">{{ __('Confirmer le mot de passe') }}</label>
                        <div class="mt-1">
                            <input id="mot_de_passe-confirm" name="mot_de_passe_confirmation" type="password" autocomplete="new-password" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#e63a28] focus:border-[#e63a28]">
                        </div>
                    </div>

                    <div>
                        <label for="image_profil" class="block text-sm font-medium text-gray-700">{{ __('Image de profil') }}</label>
                        <div class="mt-1">
                            <input id="image_profil" name="image_profil" type="file"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[#e63a28] file:text-white hover:file:bg-[#d43322] @error('image_profil') border-red-500 @enderror">
                            @error('image_profil')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center mt-3">
                    <input id="terms" name="terms" type="checkbox" required
                           class="h-4 w-4 text-[#e63a28] focus:ring-[#e63a28] border-gray-300 rounded">
                    <label for="terms" class="ml-2 block text-sm text-gray-900">
                        J'accepte les <a href="#" class="text-[#e63a28] hover:text-[#d43322]">conditions d'utilisation</a>
                    </label>
                </div>

                <div class="space-y-3">
                    <button type="submit"
                            class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#e63a28] hover:bg-[#d43322] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#e63a28] transition-colors duration-200">
                        {{ __('S\'inscrire') }}
                    </button>

                    <div class="text-center pt-1">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-[#e63a28] hover:text-[#d43322] transition-colors duration-200">
                            {{ __('Déjà un compte? Connectez-vous') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
