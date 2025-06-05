@extends('admin.layouts.app')

@section('title', 'Modifier Catégorie')

@section('content')
<div class="flex">
    @include('admin.layouts.sidebar')
    <div class="flex-1 p-6 space-y-6">
        <div class="container mx-auto px-4 py-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Modifier la catégorie</h1>
                <a href="{{ route('admin.categories.index') }}" 
                   class="text-blue-600 hover:text-blue-800">
                    Retour à la liste
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <form action="{{ route('admin.categories.update', $categorie) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">Nom de la catégorie</label>
                        <input type="text" name="nom" id="nom" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               value="{{ old('nom', $categorie->nom) }}" required>
                        @error('nom')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection