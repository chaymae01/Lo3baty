<!DOCTYPE html>
<html lang="fr" x-data="{ isFavorite: false, showScrollTop: false }" x-init="window.onscroll = () => { showScrollTop = window.scrollY > 300 }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail d'annonce - Jouets d'enfants</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/annonce-details.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/fr.js"></script>
</head>
<body class="bg-gray-50 font-sans" x-data="{ activeTab: 'reviews' }">
    @include('components.sideBar')

    <div x-show="showScrollTop" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-2"
         class="fixed bottom-8 right-8 z-50">
        <button @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                class="p-3 bg-yellow-500 text-white rounded-full shadow-lg hover:bg-blue-600 transition-all duration-300 hover:scale-110">
            <i class="fas fa-arrow-up"></i>
        </button>
    </div>
<div class="min-h-screen bg-gray-50">
    @section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-6 wow animate__fadeIn" data-wow-delay="0.1s">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ url('/') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-[#e63a28]">
                        <i class="fas fa-home mr-2"></i> Accueil
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Détails du jouet</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Main Content -->
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Column -->
            <div class="w-full lg:w-2/3">
                <!-- Image Gallery -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden wow animate__fadeIn">
                    @if($annonce->objet->images->isNotEmpty())
                        <div class="swiper-container relative">
                            @if($annonce->premium)
                                <div class="absolute top-4 left-4 z-10 bg-[#e63a28] text-white px-3 py-1 rounded-full text-xs font-semibold shadow-md flex items-center">
                                    <i class="fas fa-crown mr-1"></i> Premium
                                </div>
                            @endif
                            <div class="swiper-wrapper">
                                @foreach($annonce->objet->images as $image)
                                    <div class="swiper-slide">
                                       <img src="{{ asset('storage/' . $image->url) }}" alt="{{ $annonce->objet->nom }}" 
     class="w-full h-96 object-cover transition duration-300 hover:scale-105">
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    @else
                        <div class="h-96 bg-gray-100 flex items-center justify-center">
                            <div class="text-center text-gray-400">
                                <i class="fas fa-image fa-3x mb-3"></i>
                                <p>Aucune image disponible</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Product Details -->
                <div class="mt-8 bg-white rounded-xl shadow-lg p-6 wow animate__fadeIn">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $annonce->objet->nom }}</h1>
                    
                    <!-- Owner Info -->
                    <div class="flex items-center mb-6 p-4 bg-gray-50 rounded-lg">
                        <img class="w-12 h-12 rounded-full object-cover border-2 border-white shadow" 
                             src="{{ $annonce->proprietaire->image_profil }}" 
                             alt="{{ $annonce->proprietaire->surnom }}">
                        <div class="ml-4">
                            <p class="font-medium text-gray-900">Proposé par {{ $annonce->proprietaire->surnom }}</p>
                            <div class="flex items-center">
                                @php $avgRating = $evaluationsPartner->avg('note'); @endphp
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $avgRating)
                                            <i class="fas fa-star text-[#e63a28] text-sm"></i>
                                        @elseif($i == ceil($avgRating) && ($avgRating - floor($avgRating) >= 0.5))
                                            <i class="fas fa-star-half-alt text-[#e63a28] text-sm"></i>
                                        @else
                                            <i class="far fa-star text-gray-300 text-sm"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-600 ml-2">({{ $evaluationsPartner->count() }} avis)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold mb-4 flex items-center">
                            <i class="fas fa-align-left text-[#e63a28] mr-2"></i>Description
                        </h3>
                        <p class="text-gray-600 leading-relaxed">{{ $annonce->objet->description }}</p>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                        <div class="p-3 bg-gray-50 rounded-lg text-center hover:bg-gray-100 transition">
                            <div class="text-gray-500 mb-1">
                                <i class="fas fa-city text-[#e63a28]"></i>
                            </div>
                            <div class="font-medium">{{ $annonce->objet->ville }}</div>
                            <span class="text-xs text-gray-500">Ville</span>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg text-center hover:bg-gray-100 transition">
                            <div class="text-gray-500 mb-1">
                                <i class="fas fa-battery-three-quarters text-[#e63a28]"></i>
                            </div>
                            <div class="font-medium">{{ $annonce->objet->etat }}</div>
                            <span class="text-xs text-gray-500">État</span>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg text-center hover:bg-gray-100 transition">
                            <div class="text-gray-500 mb-1">
                                <i class="far fa-calendar-alt text-[#e63a28]"></i>
                            </div>
                            <div class="font-medium">
                                {{ \Carbon\Carbon::parse($annonce->date_publication)->format('d/m/Y') }}
                            </div>
                            <span class="text-xs text-gray-500">Publié le</span>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg text-center hover:bg-gray-100 transition">
                            <div class="text-gray-500 mb-1">
                                <i class="fas fa-child text-[#e63a28]"></i>
                            </div>
                            <div class="font-medium">{{ $annonce->objet->tranche_age }}</div>
                            <span class="text-xs text-gray-500">Âge</span>
                        </div>
                    </div>

                    <!-- Reviews -->
                    <div class="mt-8">
                        <h2 class="text-2xl font-bold mb-6 flex items-center">
                            <i class="fas fa-star mr-2 text-[#e63a28]"></i>Avis ({{ $evaluationsObjet->count() + $evaluationsPartner->count() }})
                        </h2>
                        
                        <!-- Product Reviews -->
                        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                            <div class="flex items-center mb-6">
                                <div class="text-4xl font-bold mr-4 text-[#e63a28]">{{ number_format($evaluationsObjet->avg('note'), 1) }}</div>
                                <div>
                                    <div class="flex items-center mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $evaluationsObjet->avg('note'))
                                                <i class="fas fa-star text-[#e63a28]"></i>
                                            @else
                                                <i class="far fa-star text-gray-300"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <p class="text-sm text-gray-600">{{ $evaluationsObjet->count() }} avis sur le jouet</p>
                                </div>
                            </div>
                            
                            @foreach($evaluationsObjet->take(2) as $review)
                            <div class="border-t pt-4 mt-4">
                                <div class="flex items-center mb-2">
                                    <img class="w-10 h-10 rounded-full mr-3 border-2 border-[#e63a28]" 
                                        src="{{ asset('storage/' . $review->client->image_profile) }}" 
                                        alt="{{ $review->client->surnom }}">
                                    <div>
                                        <p class="font-medium">{{ $review->client->surnom }}</p>
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star text-[{{ $i <= $review->note ? '#e63a28' : '#d1d5db' }}] text-sm"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-600">{{ $review->commentaire }}</p>
                                <p class="text-xs text-gray-400 mt-2">
                                    {{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }}
                                </p>
                            </div>
                            @endforeach
                        </div>

                        <!-- Partner Reviews -->
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex items-center mb-6">
                                <div class="text-4xl font-bold mr-4 text-[#e63a28]">{{ number_format($evaluationsPartner->avg('note'), 1) }}</div>
                                <div>
                                    <div class="flex items-center mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $evaluationsPartner->avg('note'))
                                                <i class="fas fa-star text-[#e63a28]"></i>
                                            @else
                                                <i class="far fa-star text-gray-300"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <p class="text-sm text-gray-600">{{ $evaluationsPartner->count() }} avis sur le partenaire</p>
                                </div>
                            </div>
                            
                            @foreach($evaluationsPartner->take(2) as $review)
                            <div class="border-t pt-4 mt-4">
                                <div class="flex items-center mb-2">
                                    <img class="w-10 h-10 rounded-full mr-3 border-2 border-[#e63a28]" 
                                         src="{{ $review->client->image_profil }}" 
                                         alt="{{ $review->client->surnom }}">
                                    <div>
                                        <p class="font-medium">{{ $review->client->surnom }}</p>
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star text-[{{ $i <= $review->note ? '#e63a28' : '#d1d5db' }}] text-sm"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-600">{{ $review->commentaire }}</p>
                                <p class="text-xs text-gray-400 mt-2">
                                    {{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }}
                                </p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column (Booking Form) -->
            <div class="w-full lg:w-1/3">
                <div class="sticky top-8 wow animate__fadeIn">
                    <div class="bg-white rounded-xl shadow-lg p-6 border border-[#e63a28]/20">
                        <!-- Price Header -->
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <span class="text-2xl font-bold text-[#e63a28]">
                                    {{ number_format($annonce->prix_journalier, 2) }} MAD
                                </span>
                                <span class="text-gray-500">/jour</span>
                            </div>
                            <i class="fas fa-tag text-[#e63a28]/40 text-xl"></i>
                        </div>

                        <!-- Date Picker -->
                        <div class="mb-6">
                            <div id="calendarContainer" class="border border-[#e63a28]/20 rounded-lg p-2"></div>
                        </div>

                        <!-- Reservation Form -->
                        <form id="reservationForm" action="{{ route('reservation.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="annonce_id" value="{{ $annonce->id }}">
                            
                            <!-- Date Inputs -->
                            <div class="space-y-4 mb-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="far fa-calendar-check mr-2 text-[#e63a28]"></i>Dates
                                    </label>
                                    <div class="grid grid-cols-2 gap-3">
                                        <input type="text" id="date_debut" name="date_debut" 
                                               class="w-full p-3 border border-[#e63a28]/30 rounded-lg focus:ring-2 focus:ring-[#e63a28] focus:border-[#e63a28] placeholder-gray-400"
                                               placeholder="Arrivée" readonly>
                                        <input type="text" id="date_fin" name="date_fin" 
                                               class="w-full p-3 border border-[#e63a28]/30 rounded-lg focus:ring-2 focus:ring-[#e63a28] focus:border-[#e63a28] placeholder-gray-400"
                                               placeholder="Départ" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Price Calculation -->
  <div id="priceCalculation" class="mb-4 hidden bg-white p-4 rounded-lg shadow-sm border border-blue-100 animate__animated animate__fadeIn">
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Durée:</span>
                                    <span id="durationDays" class="font-medium">0 jours</span>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Prix journalier:</span>
                                    <span class="font-medium">{{ number_format($annonce->prix_journalier, 2) }} MAD</span>
                                </div>
                                    <div class="border-t my-2 border-dashed"></div>
                                    <div class="flex justify-between">
                                        <span class="text-lg font-semibold">Total:</span>
                                        <span id="totalPrice" class="text-lg font-bold text-blue-600">0.00 MAD</span>
                                    </div>
                                </div>

                            <!-- Submit Button -->
                            <button type="submit" 
                                    class="w-full bg-[#e63a28] hover:bg-[#c5311f] text-white font-semibold py-4 px-6 rounded-lg 
                                           transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-[#e63a28]/20">
                                <i class="fas fa-lock mr-2"></i>Réserver maintenant
                            </button>
                        </form>

                        <!-- Safety Info -->
                        <div class="mt-6 text-center text-sm text-[#71AA34]">
                            <div class="flex items-center justify-center space-x-2">
                                <i class="fas fa-shield-alt"></i>
                                <span>Paiement 100% sécurisé</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6 flex items-center">
                <i class="fas fa-th-large mr-2 text-[#e63a28]"></i>Jouets Similaires
            </h2>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedProduits as $produit)
                    @php $relatedAnnonce = $produit->annonces->first(); @endphp
                    @if($relatedAnnonce)
                     <a href="{{ route('annonceID', ['id' => $relatedAnnonce->id]) }}" 
                       class="group bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow">
                        <div class="relative h-48 overflow-hidden rounded-t-xl">
                            @if($produit->images->first())
                                @if($relatedAnnonce->premium)
                                    <div class="absolute top-2 left-2 z-10 bg-[#e63a28] text-white px-2 py-1 rounded-full text-xs font-semibold">
                                        <i class="fas fa-crown mr-1"></i> Premium
                                    </div>
                                @endif
                                <img src="{{ asset('storage/' . $produit->images->first()->url) }}" 
                                    class="w-full h-full object-cover duration-300 group-hover:scale-110"
                                    alt="{{ $produit->nom }}">

                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                    <i class="fas fa-image text-gray-400 text-3xl"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="p-4">
                            <h3 class="font-medium text-gray-900 truncate">{{ $produit->nom }}</h3>
                            <div class="mt-2 flex items-center justify-between">
                                <span class="text-lg font-bold text-[#e63a28]">
                                    {{ $relatedAnnonce->prix_journalier }} MAD/jour
                                </span>
                                <span class="px-2 py-1 text-xs rounded-full bg-[#e63a28]/10 text-[#e63a28]">
                                    {{ ucfirst($produit->etat) }}
                                </span>
                            </div>
                        </div>
                    </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @show
</div>

<style>
    .swiper-button-next,
    .swiper-button-prev {
        background-color: rgba(230, 58, 40, 0.8) !important;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        transition: all 0.3s ease;
    }
    
    .swiper-button-next:hover,
    .swiper-button-prev:hover {
        background-color: rgba(230, 58, 40, 1) !important;
        transform: scale(1.1);
    }
    
    .swiper-button-next::after,
    .swiper-button-prev::after {
        color: white !important;
        font-size: 18px;
    }

    .swiper-pagination-bullet-active {
        background: #e63a28 !important;
    }

    #priceCalculation {
        opacity: 0;
        transform: translateY(10px);
    }
    
    #priceCalculation.show {
        opacity: 1;
        transform: translateY(0);
    }
</style>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/fr.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    
    <script>
        window.reservationData = {
            reservedPeriods: @json($reservedPeriods),
            annonceStartDate: '{{ \Carbon\Carbon::parse($annonce->date_debut)->format("Y-m-d") }}',
            annonceEndDate: '{{ \Carbon\Carbon::parse($annonce->date_fin)->format("Y-m-d") }}',
            dailyPrice: {{ $annonce->prix_journalier }},
            locale: 'fr',
            currency: 'MAD'
        };
    </script> 

    <script>
        new WOW().init();
    </script>

    @if($annonce->objet->images->isNotEmpty())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.swiper-container', {
                loop: true,
                autoplay: {
                    delay: 3000,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        });
    </script>
    @endif

    <!-- Custom JS -->
    <script src="{{ asset('js/annonce-details.js') }}"></script>
    @stack('scripts')
</body>
</html>