@extends('layouts.app')

@section('title', 'Connexion - Lo3baty') 

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
        <div class="bg-white p-8 rounded-lg shadow-md">
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('storage/images/Lo3baty.jpg') }}" 
                         alt="Lo3baty Logo" 
                         class="h-20 w-auto mx-auto hover:opacity-92 transition-opacity">
                </a>
            </div>

            <div class="text-center">
                <h2 class="mt-2 text-3xl font-bold text-gray-900">{{ __('Connexion') }}</h2>
            </div>

            <form class="mt-6 space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" autocomplete="email" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#e63a28] focus:border-[#e63a28] @error('email') border-red-500 @enderror"
                                   value="{{ old('email') }}">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="mot_de_passe" class="block text-sm font-medium text-gray-700">{{ __('Mot de passe') }}</label>
                        <div class="mt-1">
                            <input id="mot_de_passe" name="mot_de_passe" type="password" autocomplete="current-password" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#e63a28] focus:border-[#e63a28] @error('mot_de_passe') border-red-500 @enderror">
                            @error('mot_de_passe')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                               class="h-4 w-4 text-[#e63a28] focus:ring-[#e63a28] border-gray-300 rounded" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" class="ml-2 block text-sm text-gray-900">
                            {{ __('Se souvenir de moi') }}
                        </label>
                    </div>
                </div>

                <div class="space-y-4">
                    <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#e63a28] hover:bg-[#d0311f] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#e63a28] transition-colors">
                        {{ __('Connexion') }}
                    </button>

                    @if (Route::has('password.request'))
                        <div class="text-center">
                            <a href="{{ route('password.request') }}" class="text-sm font-medium text-[#e63a28] hover:text-[#d0311f]">
                                {{ __('Mot de passe oublié?') }}
                            </a>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection