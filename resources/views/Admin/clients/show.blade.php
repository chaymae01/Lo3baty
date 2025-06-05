@extends('admin.layouts.app')

@section('title', 'Profil Client')

@section('content')
<div class="flex">
    @include('admin.layouts.sidebar')

    <div class="flex-1 p-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center space-x-6 mb-6">
                <div class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                    <img src="{{ $client->getProfileImageAttribute() }}" alt="Photo de profil" class="h-full w-full object-cover">
                </div>
                <div>
                    <h1 class="text-2xl font-bold">{{ $client->prenom }} {{ $client->nom }}</h1>
                    <p class="text-gray-600">{{ $client->email }}</p>
                    <span class="inline-block mt-2 px-3 py-1 rounded-full text-sm font-semibold {{ $client->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $client->isActive() ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-lg font-semibold mb-4">Informations personnelles</h2>
                    <div class="space-y-2">
                        <p><span class="font-medium">Surnom:</span> {{ $client->surnom }}</p>
                        <p><span class="font-medium">Date d'inscription:</span> {{ $client->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg font-semibold mb-4">Statistiques</h2>
                    <div class="space-y-2">
                        <p><span class="font-medium">Nombre de réservations:</span> {{ $client->reservations->count() }}</p>
                        <p><span class="font-medium">Dernière activité:</span> {{ $client->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <a href="{{ route('admin.clients.index') }}" class="btn btn-primary">
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>
</div>
@endsection