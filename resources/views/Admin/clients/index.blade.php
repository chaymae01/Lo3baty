@extends('admin.layouts.app')

@section('title', 'Gestion des clients')

@section('content')
<div class="flex bg-gray-50 min-h-screen">
    <!-- Sidebar FIXE -->
    <div class="fixed top-0 left-0 h-screen w-64 bg-white shadow-lg z-10">
        @include('admin.layouts.sidebar')
    </div>

    <!-- Contenu principal -->
    <div class="ml-64 flex-1 p-6 space-y-6 overflow-auto">
    <!-- Titre FIXE -->
    <div class="flex justify-between items-center mt-4">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des clients</h1>
    </div>


        <!-- Notification -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow-sm mb-4">
            {{ session('success') }}
        </div>
        @endif

        <!-- Section Filtres -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <form method="GET" action="{{ route('admin.clients') }}" class="flex flex-wrap gap-4 items-end">
                <!-- Filtre par surnom -->
                <div>
                    <label for="surnom" class="block text-sm font-medium text-gray-700">Surnom</label>
                    <input type="text" name="surnom" id="surnom" value="{{ request('surnom') }}" class="mt-1 block w-52 rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 text-sm">
                </div>

                <!-- Filtre par statut -->
                <div>
                    <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
                    <select name="statut" id="statut" class="mt-1 block w-40 rounded-lg border-gray-300 shadow-sm text-sm">
                        <option value="">Tous</option>
                        <option value="actif" {{ request('statut') == 'actif' ? 'selected' : '' }}>Actif</option>
                        <option value="inactif" {{ request('statut') == 'inactif' ? 'selected' : '' }}>Inactif</option>
                    </select>
                </div>

                <button type="submit" class="px-6 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    Filtrer
                </button>
            </form>
        </div>

        <!-- Tableau des clients -->
        <div class="bg-white rounded-lg shadow-md p-6 space-y-4 mt-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Liste des clients</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase">Nom</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase">Surnom</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase">Email</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase">Statut</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($clients as $client)
                        <tr>
                            <td class="px-6 py-4 text-gray-800">{{ $client->prenom }} {{ $client->nom }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $client->surnom }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $client->email }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $client->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $client->isActive() ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('admin.clients.toggle-status', $client) }}">
                                    @csrf
                                    <button type="submit" class="px-4 py-1 rounded-full text-xs font-semibold transition duration-200 {{ $client->isActive() ? 'bg-red-500 hover:bg-red-600 text-white' : 'bg-green-500 hover:bg-green-600 text-white' }}">
                                        {{ $client->isActive() ? 'Désactiver' : 'Activer' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucun client trouvé.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pt-4">
                {{ $clients->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
