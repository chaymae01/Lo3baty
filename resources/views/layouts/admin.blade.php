<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Lo3baty') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div id="app">
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ url('/') }}" class="text-xl font-bold text-gray-900">
                                {{ config('app.name', 'Lo3baty') }}
                            </a>
                        </div>
                    </div>

                    <div class="hidden sm:ml-6 sm:flex sm:items-center">
                        @guest
                            <a href="{{ route('login') }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">
                                {{ __('Connexion') }}
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">
                                    {{ __('Inscription') }}
                                </a>
                            @endif
                        @else
                            <div x-data="{ open: false }" class="ml-3 relative">
                                <div class="flex items-center">
                                    <button @click="open = !open" class="max-w-xs flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <span class="sr-only">Open user menu</span>
                                        <span class="ml-2 text-sm font-medium text-gray-700">
                                            {{ Auth::user()->prenom }} {{ Auth::user()->nom }}
                                        </span>
                                        <svg class="ml-1 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>

                                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <a href="{{ route('logout') }}" 
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        {{ __('Déconnexion') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                        @csrf
                                    </form>
                                </div>
                            </div>

                            @if (Auth::check())
                        
                        <div class="ml-6 flex items-center space-x-4">
                            @if(Auth::user()->role === 'client')
                                <!-- Bouton Devenir Partenaire (visible seulement pour les clients) -->
                                <a href="{{ route('partenaire.contrat') }}" 
                                   class="px-4 py-2 text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    Devenir Partenaire
                                </a>
                            @endif
                        
                            <!-- Bouton Espace Client (toujours visible) -->
                           
                        
                            @if(Auth::user()->role === 'partenaire')
                                <!-- Bouton Espace Partenaire (visible seulement pour les partenaires) -->
                                <a href="{{ route('partenaire.contrat') }}" 
                                   class="px-4 py-2 text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                    Espace Partenaire
                                </a>
                                <a href="{{ route('client.home') }}" 
                               class="px-4 py-2 text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                Espace Client
                            </a>
                            @endif
                        </div>
                        @endif
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>