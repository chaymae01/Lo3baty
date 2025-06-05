@extends('admin.layouts.app')

@section('title', 'Ajouter une Catégorie')

@section('content')
<div class="flex">
    @include('admin.layouts.sidebar')
    <div class="flex-1 p-6 space-y-6">
        <div class="container mx-auto px-4 py-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Ajouter une catégorie</h1>
                <a href="{{ route('admin.categories.index') }}" 
                   class="text-blue-600 hover:text-blue-800">
                    Retour à la liste
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <form action="{{ route('admin.categories.store') }}" method="POST" class="p-6">
                    @csrf

                    <div class="mb-6">
                        <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                            Nom de la catégorie *
                        </label>
                        <input type="text" name="nom" id="nom" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required>
                        @error('nom')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                            Créer la catégorie
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection