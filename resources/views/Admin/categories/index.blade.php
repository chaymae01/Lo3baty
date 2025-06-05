@extends('admin.layouts.app')

@section('title', 'Gestion des Catégories')

@section('content')
<div class="flex">
    @include('admin.layouts.sidebar')
    <div class="flex-1 p-6">
        <div class="container mx-auto px-4 py-6">
            <!-- En-tête avec barre de recherche -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-bold text-gray-800">Gestion des Catégories</h1>
                    <a href="{{ route('admin.categories.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md transition duration-300 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Ajouter une catégorie
                    </a>
                </div>

                <!-- Barre de recherche/filtrage -->
                <form method="GET" action="{{ route('admin.categories.index') }}" class="mb-6">
                    <div class="relative max-w-md">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Rechercher par nom..." 
                            value="{{ request('search') }}"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        >
                        @if(request('search'))
                            <a href="{{ route('admin.categories.index') }}" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Liste des catégories -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($categories as $categorie)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 border border-gray-100">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <h3 class="text-xl font-semibold text-gray-800 truncate max-w-[65%]">{{ $categorie->nom }}</h3>
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full whitespace-nowrap">
                                ID: {{ $categorie->id }}
                            </span>
                        </div>
                        
                        <div class="mt-6 pt-4 border-t">
                            <div class="flex flex-wrap justify-between items-center gap-2">
                                <!-- Bouton Détails -->
                                <a href="{{ route('admin.categories.show', $categorie) }}" 
                                   class="text-blue-600 hover:text-blue-800 px-2 py-1 rounded-md flex items-center transition-colors duration-200 text-sm whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                    Détails
                                </a>
                                
                                <div class="flex flex-wrap gap-2">
                                    <!-- Bouton Modifier -->
                                    <a href="{{ route('admin.categories.edit', $categorie) }}" 
                                       class="bg-yellow-100 hover:bg-yellow-200 text-yellow-800 px-2 py-1 rounded-md flex items-center transition-colors duration-200 border border-yellow-200 text-sm whitespace-nowrap">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                        Modifier
                                    </a>
                                    
                                    <!-- Bouton Supprimer -->
                                    <form action="{{ route('admin.categories.destroy', $categorie) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-100 hover:bg-red-200 text-red-800 px-2 py-1 rounded-md flex items-center transition-colors duration-200 border border-red-200 text-sm whitespace-nowrap"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-12 text-center">
                    <p class="text-gray-500 text-lg">
                        @if(request('search'))
                            Aucune catégorie trouvée pour "{{ request('search') }}"
                        @else
                            Aucune catégorie disponible
                        @endif
                    </p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $categories->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </div>
</div>
@endsection