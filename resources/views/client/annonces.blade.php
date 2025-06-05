<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annonces</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
          crossorigin=""/>
    <style>
        .filter-card { transition: all 0.3s ease; }
        .filter-card:hover { transform: translateY(-2px); }
        .filter-radio:checked + .filter-label { border-color: #e63a28; background-color: #FEE2E2; }
        .filter-radio:checked + .filter-label .filter-check { opacity: 1; }
        .filter-scroll { scrollbar-width: thin; scrollbar-color: #CBD5E0 #F3F4F6; }
        .filter-scroll::-webkit-scrollbar { width: 6px; }
        .filter-scroll::-webkit-scrollbar-track { background: #F3F4F6; border-radius: 3px; }
        .filter-scroll::-webkit-scrollbar-thumb { background-color: #CBD5E0; border-radius: 3px; }
        .filter-scroll::-webkit-scrollbar-thumb:hover { background-color: #9CA3AF; }
        #map { height: 600px; z-index: 1; }
        .leaflet-popup-content-wrapper { border-radius: 8px; }
    </style>
</head>

<body class="bg-gray-100">
    @include('components.sideBar')

    <div class="flex flex-col md:flex-row">
        <!-- Filter Sidebar -->
        <form id="mainFilterForm" method="GET" action="{{ route('annonces') }}" class="w-full md:w-72 bg-white p-5 shadow-lg rounded-lg sticky-sidebar md:mt-4 md:ml-4 h-[calc(100vh-2rem)] flex flex-col">
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-800">Filtres</h2>
                <a href="{{ route('annonces') }}" class="text-sm text-[#e63a28] hover:text-[#c5301e]">Réinitialiser</a>
            </div>

            <div class="filter-scroll overflow-y-auto flex-1 pr-2 -mr-2">
                <!-- Age Filter -->
                <div class="mb-8">
                    <h3 class="font-semibold mb-4 text-gray-700 text-lg flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#e63a28]" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                        </svg>
                        Tranche d'âge
                    </h3>
                    <div class="grid gap-2">
                        @foreach (['<3' => 'Moins de 3 ans', '3-5' => '3-5 ans', '6-8' => '6-8 ans', '9-12' => '9-12 ans', '13+' => '13+ ans'] as $age => $label)
                            <div class="filter-card">
                                <input type="radio" id="age-{{ $age }}" name="age" value="{{ $age }}" 
                                       {{ request('age') == $age ? 'checked' : '' }} class="hidden filter-radio">
                                <label for="age-{{ $age }}" class="filter-label flex items-center cursor-pointer p-3 border border-gray-200 rounded-lg hover:border-[#e63a28]">
                                    <span class="w-5 h-5 rounded-full border-2 border-gray-300 mr-3 flex items-center justify-center">
                                        <span class="w-2 h-2 rounded-full bg-[#e63a28] opacity-0 transition-opacity filter-check"></span>
                                    </span>
                                    <span class="text-gray-700">{{ $label }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Price Filter -->
                <div class="mb-8">
                    <h3 class="font-semibold mb-4 text-gray-700 text-lg flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#e63a28]" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                        </svg>
                        Prix
                    </h3>
                    <div class="grid gap-2">
                        @foreach (['0-50' => 'Moins de 50Dhs', '50-100' => '50Dhs - 100Dhs', '100-150' => '100Dhs - 150Dhs', '150+' => 'Plus de 150Dhs'] as $val => $label)
                            <div class="filter-card">
                                <input type="radio" id="price-{{ $val }}" name="price" value="{{ $val }}" 
                                       {{ request('price') == $val ? 'checked' : '' }} class="hidden filter-radio">
                                <label for="price-{{ $val }}" class="filter-label flex items-center cursor-pointer p-3 border border-gray-200 rounded-lg hover:border-[#e63a28]">
                                    <span class="w-5 h-5 rounded-full border-2 border-gray-300 mr-3 flex items-center justify-center">
                                        <span class="w-2 h-2 rounded-full bg-[#e63a28] opacity-0 transition-opacity filter-check"></span>
                                    </span>
                                    <span class="text-gray-700">{{ $label }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Type Filter -->
                <div class="mb-8">
                    <h3 class="font-semibold mb-4 text-gray-700 text-lg flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#e63a28]" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Type de jeu
                    </h3>
                    <div class="grid gap-2">
                        @foreach (['Jeux éducatifs', 'Jeux d\'amusement', 'Jeux créatifs', 'Jeux de stratégie'] as $type)
                            <div class="filter-card">
                                <input type="radio" id="type-{{ $loop->index }}" name="type" value="{{ $type }}" 
                                       {{ request('type') == $type ? 'checked' : '' }} class="hidden filter-radio">
                                <label for="type-{{ $loop->index }}" class="filter-label flex items-center cursor-pointer p-3 border border-gray-200 rounded-lg hover:border-[#e63a28]">
                                    <span class="w-5 h-5 rounded-full border-2 border-gray-300 mr-3 flex items-center justify-center">
                                        <span class="w-2 h-2 rounded-full bg-[#e63a28] opacity-0 transition-opacity filter-check"></span>
                                    </span>
                                    <span class="text-gray-700">{{ $type }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            

            <!-- Ville Filter -->
    <div class="mb-8">
    <h3 class="font-semibold mb-4 text-gray-700 text-lg flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#e63a28]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zm0 9c-4.418 0-8-5.373-8-9a8 8 0 1116 0c0 3.627-3.582 9-8 9z" />
    </svg>
        Ville
    </h3>
    <div class="grid gap-2">
        @foreach ($villes as $ville)
            <div class="filter-card">
                <input type="radio" id="ville-{{ $loop->index }}" name="ville" value="{{ $ville }}"
                       {{ request('ville') == $ville ? 'checked' : '' }} class="hidden filter-radio">
                <label for="ville-{{ $loop->index }}" class="filter-label flex items-center cursor-pointer p-3 border border-gray-200 rounded-lg hover:border-[#e63a28]">
                    <span class="w-5 h-5 rounded-full border-2 border-gray-300 mr-3 flex items-center justify-center">
                        <span class="w-2 h-2 rounded-full bg-[#e63a28] opacity-0 transition-opacity filter-check"></span>
                    </span>
                    <span class="text-gray-700">{{ $ville }}</span>
                </label>
            </div>
        @endforeach
    </div>
    </div>
    </div>

            <!-- <input type="hidden" name="ville" id="villeInput" value="{{ request('ville') }}"> -->
            <input type="hidden" name="search" id="searchInput" value="{{ request('search') }}">
            <input type="hidden" name="sort" id="sortInput" value="{{ request('sort') }}">
        </form>

        <div class="flex-1 p-5">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <div class="w-full flex flex-col sm:flex-row gap-4 items-center">
                    <div class="flex items-center w-full sm:w-auto">
                        <span class="text-gray-600 mr-2">Trier par :</span>
                        <select id="sortSelect" class="bg-white border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#e63a28]">
                            <option value="">--</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                        </select>
                    </div>
                    <div class="relative w-full sm:w-64">
                        <input type="text" id="searchField" value="{{ request('search') }}" 
                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-1 focus:ring-[#e63a28]" 
                               placeholder="Rechercher...">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <button id="toggleView" class="bg-[#e63a28] hover:bg-[#c5301e] text-white px-4 py-2 rounded-lg transition-colors">
                    Afficher la carte
                </button>
            </div>

            <!-- Map Container -->
            <div id="mapContainer" class="hidden mb-5 rounded-lg overflow-hidden shadow-lg border border-gray-200">
                <div id="map"></div>
            </div>

            <!-- Annonces List -->
            <section id="annoncesList" class="w-fit mx-auto grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 justify-items-center gap-y-20 gap-x-14 mt-10 mb-5">
                @forelse ($annonces as $annonce)
                    <div class="w-72 bg-white shadow-md rounded-xl duration-100 hover:scale-105 hover:shadow-l">
                        <a href="{{ route('annonceID', ['id' => $annonce->id]) }}">
                            <img src="{{ $annonce->objet->images->first() ? asset('storage/' . $annonce->objet->images->first()->url) : 'https://via.placeholder.com/288x320' }}" 
                                alt="{{ $annonce->objet->nom }}" 
                                class="h-80 w-72 object-cover rounded-t-xl">
                            <div class="px-4 py-3 w-72">
                                <p class="text-lg font-bold text-black truncate">{{ $annonce->objet->nom }}</p>
                                <div class="flex items-center justify-between mt-2">
                                    <p class="text-md font-medium text-black">{{ $annonce->prix_journalier }} Dhs</p>
                                    <span class="bg-[#e63a28] text-white px-4 py-2 rounded-lg text-sm">
                                        Détails
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="text-center col-span-full text-gray-600">Aucun produit trouvé.</p>
                @endforelse
            </section>

            <!-- Pagination -->
            <div class="flex justify-center mt-12">
                {{ $annonces->withQueryString()->links() }}
            </div>
        </div>
    </div>


    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>

    <script>
          let map = null;
    const toggleButton = document.getElementById('toggleView');
    
    // Explicit JSON encoding
    const annoncesData = JSON.parse('{!! json_encode($annonces->map(function ($annonce) {
        return [
            'id' => $annonce->id,
            'title' => $annonce->objet->nom,
            'price' => $annonce->prix_journalier,
            'address' => $annonce->adresse,
            'image' => $annonce->image_url ?? 'https://via.placeholder.com/100x100',
            'link' => route('annonceID', ['id' => $annonce->id]),
            'lat' => $annonce->latitude,
            'lng' => $annonce->longitude
        ];
    })) !!}');

        // Initialize Map with Markers
        function initMap() {
            map = L.map('map').setView([31.7917, -7.0926], 6);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Add markers for each annonce with coordinates
            annoncesData.forEach(annonce => {
                if (annonce.lat && annonce.lng) {
                    const marker = L.marker([annonce.lat, annonce.lng]).addTo(map);
                    marker.bindPopup(`
                        <div class="popup-content">
                            <img src="${annonce.image}" alt="${annonce.title}" 
                                 class="w-full h-32 object-cover mb-2 rounded">
                            <h3 class="font-bold text-lg">${annonce.title}</h3>
                            <p class="text-gray-600">${annonce.price} Dhs/jour</p>
                            <a href="${annonce.link}" class="text-blue-500 hover:underline">Voir détails →</a>
                        </div>
                    `);
                }
            });

            // Adjust map view to show all markers
            const markers = L.featureGroup(
                annoncesData
                    .filter(a => a.lat && a.lng)
                    .map(a => L.marker([a.lat, a.lng]))
            );
            
            if (markers.getLayers().length > 0) {
                map.fitBounds(markers.getBounds().pad(0.2));
            }
        }

        // Toggle View
        toggleButton.addEventListener('click', () => {
            document.getElementById('annoncesList').classList.toggle('hidden');
            document.getElementById('mapContainer').classList.toggle('hidden');
            
            if (document.getElementById('mapContainer').classList.contains('hidden')) {
                toggleButton.textContent = 'Afficher la carte';
            } else {
                toggleButton.textContent = 'Afficher la liste';
                if (!map) initMap();
            }
        });

        // Filter functionality
        document.querySelectorAll('.filter-radio').forEach(radio => {
            radio.addEventListener('change', () => document.getElementById('mainFilterForm').submit());
        });

        // Search functionality
        document.getElementById('searchField').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                document.getElementById('searchInput').value = e.target.value;
                document.getElementById('mainFilterForm').submit();
            }
        });

        // Sort functionality
        document.getElementById('sortSelect').addEventListener('change', function() {
            document.getElementById('sortInput').value = this.value;
            document.getElementById('mainFilterForm').submit();
        });
        
    </script>
</body>
</html>