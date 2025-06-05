@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-green-600 text-white">
                <h2 class="text-xl font-semibold">Tableau de Bord Partenaire</h2>
            </div>
            
            <div class="p-6">
                <p class="mb-6 text-gray-700">Bienvenue Partenaire, {{ Auth::user()->name }} !</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Vos éléments de dashboard partenaire ici -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
