@extends('layouts.partenaire')

@section('content')
<main class="flex-1 p-8 overflow-y-auto bg-gray-50">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg space-y-6">

        <!-- Titre -->
        <h1 class="text-3xl font-bold text-indigo-800 flex items-center gap-2">
            ➕ Créer une annonce pour <span class="text-gray-600">{{ $objet->nom }}</span>
        </h1>

        <!-- 🔔 erreurs -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-6">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulaire -->
        <form method="POST" action="{{ route('partenaire.annonces.store') }}" class="space-y-6">
            @csrf

            <!-- Objet (hidden) -->
            <input type="hidden" name="objet_id" value="{{ $objet->id }}">
            <input type="hidden" name="latitude" id="lat">
            <input type="hidden" name="longitude" id="lng">

            <!-- Infos objet -->
            <div class="bg-gray-50 p-4 rounded-lg border space-y-2">
                <p><strong>🧸 Objet :</strong> {{ $objet->nom }}</p>
                <p><strong>📍 Ville :</strong> {{ $objet->ville }}</p>
                <p><strong>ℹ️ Description :</strong> {{ $objet->description }}</p>
            </div>

            <!-- 🔍 Recherche d’adresse -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">🔎 Chercher une adresse :</label>
                <input type="text" id="search-input"
                       placeholder="Ex: 12 rue Mohammed V, Rabat"
                       class="w-full border border-gray-300 rounded px-4 py-2 shadow-sm focus:ring focus:ring-indigo-200">
            </div>

            <!-- Coordonnées -->
            <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                <div class="bg-gray-100 px-4 py-2 rounded">
                    <strong>Latitude :</strong> <span id="display-lat">–</span>
                </div>
                <div class="bg-gray-100 px-4 py-2 rounded">
                    <strong>Longitude :</strong> <span id="display-lng">–</span>
                </div>
            </div>

            <!-- 🗺️ Carte -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">📍 Localisation sur carte</label>
                <div id="map" class="h-64 w-full rounded shadow border border-gray-300"></div>
            </div>

            <!-- Prix -->
            <div>
                <label for="prix_journalier" class="block text-sm font-medium text-gray-700 mb-1">💰 Prix journalier (DH)</label>
                <input type="number" name="prix_journalier" id="prix_journalier"
                       value="{{ old('prix_journalier', $objet->prix_journalier ?? '') }}"
                       class="w-full border border-gray-300 rounded px-4 py-2 shadow-sm focus:ring focus:ring-indigo-200" step="0.01">
            </div>

            <!-- Dates -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-1">📅 Date de début</label>
                    <input type="date" name="date_debut" id="date_debut"
                           value="{{ old('date_debut') }}"
                           class="w-full border border-gray-300 rounded px-4 py-2 shadow-sm focus:ring focus:ring-indigo-200">
                </div>
                <div>
                    <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-1">📅 Date de fin</label>
                    <input type="date" name="date_fin" id="date_fin"
                           value="{{ old('date_fin') }}"
                           class="w-full border border-gray-300 rounded px-4 py-2 shadow-sm focus:ring focus:ring-indigo-200">
                </div>
            </div>

            <!-- 💎 Premium -->
            <div id="premium-section" class="space-y-3">
                <div class="flex items-center space-x-3">
                    <input type="checkbox" id="premium" name="premium" value="1"
                           class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 transition">
                    <label for="premium" class="text-gray-800 font-medium">💎 Activer l’annonce premium</label>
                </div>

                <div id="premium-options" class="hidden">
                    <label for="premium_periode" class="block text-sm font-medium text-gray-700 mb-1">Durée premium (en jours)</label>
                    <select name="premium_periode" id="premium_periode" class="w-full border rounded px-3 py-2">
                        <option value="">-- Choisir la période --</option>
                        <option value="7">7 jours</option>
                        <option value="15">15 jours</option>
                        <option value="30">30 jours</option>
                    </select>
                </div>
            </div>

            <!-- ✅ Bouton -->
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-6 py-3 rounded-lg shadow-md transition w-full">
                ✅ Créer l’annonce
            </button>
        </form>

    </div>
</main>

<!-- 📍 Script Google Maps avec autocomplete -->
<script>
    window.initMap = function () {
        const defaultLatLng = { lat: 33.9716, lng: -6.8498 };
        const map = new google.maps.Map(document.getElementById("map"), {
            center: defaultLatLng,
            zoom: 6,
        });

        let marker = new google.maps.Marker({
            map: map,
            draggable: true,
            position: defaultLatLng,
        });

        updateCoords(defaultLatLng.lat, defaultLatLng.lng);

        const input = document.getElementById("search-input");
        const autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo("bounds", map);

        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();
            if (!place.geometry || !place.geometry.location) {
                alert("Adresse non valide.");
                return;
            }

            const location = place.geometry.location;
            map.setCenter(location);
            map.setZoom(14);

            marker.setPosition(location);
            updateCoords(location.lat(), location.lng());
        });

        map.addListener("click", function (e) {
            const lat = e.latLng.lat();
            const lng = e.latLng.lng();
            marker.setPosition(e.latLng);
            updateCoords(lat, lng);
        });

        marker.addListener("dragend", function () {
            const pos = marker.getPosition();
            updateCoords(pos.lat(), pos.lng());
        });

        function updateCoords(lat, lng) {
            const fixedLat = lat.toFixed(7);
            const fixedLng = lng.toFixed(7);
            document.getElementById("lat").value = fixedLat;
            document.getElementById("lng").value = fixedLng;
            document.getElementById("display-lat").textContent = fixedLat;
            document.getElementById("display-lng").textContent = fixedLng;
        }
    };

    // ✅ Gérer l'affichage des options premium quand la checkbox est cochée
    document.addEventListener('DOMContentLoaded', function () {
        const premiumCheckbox = document.getElementById('premium');
        const premiumOptions = document.getElementById('premium-options');

        premiumCheckbox.addEventListener('change', function () {
            if (premiumCheckbox.checked) {
                premiumOptions.classList.remove('hidden');
            } else {
                premiumOptions.classList.add('hidden');
            }
        });
    });
</script>

<!-- 📦 API Key avec Places -->
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places&callback=initMap" async defer></script>
@endsection
