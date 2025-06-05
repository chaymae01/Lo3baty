@extends('layouts.partenaire')

@section('content')
    <main class="flex-1 p-8 overflow-y-auto bg-gray-50">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg space-y-6">

            <!-- Titre -->
            <h1 class="text-3xl font-bold text-indigo-800 flex items-center gap-2">
                ✏️ Modifier l'annonce
                <span class="text-gray-500 text-lg">– {{ $annonce->objet->nom }}</span>
            </h1>

            <!-- Formulaire -->
            <form method="POST" action="{{ route('partenaire.annonces.update', $annonce) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Hidden coords -->
                @php
                    $coords = explode(',', $annonce->adresse ?? '0,0');
                    $latitude = $coords[0] ?? '0';
                    $longitude = $coords[1] ?? '0';
                @endphp

                <input type="hidden" name="latitude" id="lat" value="{{ $latitude }}">
                <input type="hidden" name="longitude" id="lng" value="{{ $longitude }}">



                <!-- Saisie d'adresse -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">🔎 Chercher une adresse :</label>
                    <input id="search-input" type="text" placeholder="Ex: 12 rue Mohammed V, Rabat"
                        class="w-full border border-gray-300 rounded px-4 py-2 shadow-sm focus:ring focus:ring-indigo-200">
                </div>



                <!-- Carte -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">📍 Nouvelle position sur carte :</label>
                    <div id="map" class="h-64 w-full rounded-xl border border-gray-300 shadow-sm"></div>

                    <!-- Coordonnées visibles -->
                    <div class="mt-3 flex flex-wrap gap-4">
                        <div class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm">
                            <strong>Latitude :</strong> <span
                                id="display-lat">{{ explode(',', $annonce->adresse)[0] }}</span>
                        </div>
                        <div class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm">
                            <strong>Longitude :</strong> <span
                                id="display-lng">{{ explode(',', $annonce->adresse)[1] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Prix -->
                <div>
                    <label for="prix_journalier" class="block text-sm font-medium text-gray-700 mb-1">💰 Prix journalier (DH)</label>
                    <input type="number" step="0.01" min="0" name="prix_journalier" id="prix_journalier"
                        value="{{ old('prix_journalier', $annonce->prix_journalier) }}"
                        class="w-full border rounded px-3 py-2" required>
                </div>

                <!-- Dates -->
                <div>
                    <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-1">📅 Date de début</label>
                    <input type="date" name="date_debut" id="date_debut"
                        value="{{ old('date_debut', $annonce->date_debut ? $annonce->date_debut->format('Y-m-d') : '') }}"
                        class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-1">📅 Date de fin</label>
                    <input type="date" name="date_fin" id="date_fin"
                        value="{{ old('date_fin', $annonce->date_fin ? $annonce->date_fin->format('Y-m-d') : '') }}"
                        class="w-full border rounded px-3 py-2" required>
                </div>
                                

                {{-- Vérifier si l'annonce est actuellement premium --}}
                @php
                    $daysLeft = null;
                    if ($annonce->premium && $annonce->premium_start_date && $annonce->premium_periode) {
                        $daysSinceStart = \Carbon\Carbon::parse($annonce->premium_start_date)->diffInDays(now());
                        $daysLeft = $annonce->premium_periode - $daysSinceStart;
                    }
                @endphp

                @if ($annonce->premium && $daysLeft > 0)
                    {{-- ✅ Premium en cours --}}
                    <div class="mb-4 p-4 bg-yellow-100 text-yellow-800 rounded shadow">
                        💎 Cette annonce est <strong>premium</strong> pour encore 
                        <strong>{{ $daysLeft }}</strong> jour(s).
                    </div>

                    {{-- Option pour désactiver --}}
                    <div class="flex items-center space-x-3 mt-4">
                        <input type="hidden" name="remove_premium" value="0">
                        <input type="checkbox" id="remove_premium" name="remove_premium" value="1"
                            class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring-red-500 transition">
                        <label for="remove_premium" class="text-red-700 font-medium">
                            ❌ Désactiver l’annonce premium
                        </label>
                    </div>

                @else
                    {{-- 🚀 Option pour activer premium --}}
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <input type="hidden" name="premium" value="0">
                            <input type="checkbox" id="premium" name="premium" value="1"
                                class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 transition"
                                {{ old('premium') ? 'checked' : '' }}>
                            <label for="premium" class="text-gray-800 font-medium">
                                💎 Activer l’annonce premium
                            </label>
                        </div>

                        <!-- Choisir la période -->
                        <div>
                            <label for="premium_periode" class="block text-sm font-medium text-gray-700 mb-1">Durée (en jours)</label>
                            <select name="premium_periode" id="premium_periode" class="w-full border rounded px-3 py-2">
                                <option value="">-- Choisir la période --</option>
                                <option value="7" {{ old('premium_periode', $annonce->premium_periode) == '7' ? 'selected' : '' }}>7 jours</option>
                                <option value="15" {{ old('premium_periode', $annonce->premium_periode) == '15' ? 'selected' : '' }}>15 jours</option>
                                <option value="30" {{ old('premium_periode', $annonce->premium_periode) == '30' ? 'selected' : '' }}>30 jours</option>
                            </select>
                        </div>
                    </div>
                @endif



                <!-- Bouton -->
                <div>
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-6 py-3 rounded-lg shadow-md transition">
                        💾 Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        window.initMap = function () {
            const lat = parseFloat(document.getElementById("lat").value);
            const lng = parseFloat(document.getElementById("lng").value);
            const map = new google.maps.Map(document.getElementById("map"), {
                center: { lat, lng },
                zoom: 12,
            });

            let marker = new google.maps.Marker({
                position: { lat, lng },
                map: map,
                draggable: true
            });

            // Autocomplete
            const input = document.getElementById("search-input");
            const autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo("bounds", map);

            autocomplete.addListener("place_changed", () => {
                const place = autocomplete.getPlace();
                if (!place.geometry || !place.geometry.location) {
                    alert("Adresse non valide");
                    return;
                }

                const location = place.geometry.location;
                map.setCenter(location);
                map.setZoom(14);

                const newLat = location.lat().toFixed(7);
                const newLng = location.lng().toFixed(7);

                marker.setPosition(location);
                updateCoords(newLat, newLng);
            });

            // Mise à jour coords quand déplacement manuel
            marker.addListener("dragend", function () {
                const pos = marker.getPosition();
                updateCoords(pos.lat().toFixed(7), pos.lng().toFixed(7));
            });

            // Mise à jour de tous les champs
            function updateCoords(lat, lng) {
                document.getElementById("lat").value = lat;
                document.getElementById("lng").value = lng;
                document.getElementById("display-lat").innerText = lat;
                document.getElementById("display-lng").innerText = lng;
            }

            map.addListener("click", function (e) {
                const newLat = e.latLng.lat().toFixed(7);
                const newLng = e.latLng.lng().toFixed(7);
                marker.setPosition(e.latLng);
                updateCoords(newLat, newLng);
            });
        };
    </script>


<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places&callback=initMap" async defer></script>

@endsection