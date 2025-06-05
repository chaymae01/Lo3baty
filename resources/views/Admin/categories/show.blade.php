@extends('admin.layouts.app')

@section('title', 'Détails de la Catégorie')

@section('content')
<div class="flex">
    @include('admin.layouts.sidebar')
    <div class="flex-1 p-6 space-y-6">
        <div class="container mx-auto px-4 py-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Détails de la catégorie</h1>
                <a href="{{ route('admin.categories.index') }}" 
                   class="text-blue-600 hover:text-blue-800">
                    Retour à la liste
                </a>
            </div>
<div class="flex space-x-4 mt-6">
    <a href="{{ route('admin.categories.edit', $categorie) }}"
       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md">
        Modifier
    </a>
    <a href="{{ route('admin.categories.index') }}"
       class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
        Retour
    </a>
</div>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6">
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-gray-800">{{ $categorie->nom }}</h2>
                        <p class="text-gray-600 mt-2">Créée le {{ $categorie->created_at->format('d/m/Y') }}</p>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium mb-4">Informations</h3>
                        <p class="text-gray-600">Cette catégorie ne contient pas d'informations supplémentaires.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection