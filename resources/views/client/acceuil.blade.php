<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Lo3baty</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- CSS Dependencies -->
    <link href="{{ asset('css/acceuil.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    
</head>
<body style="background-color: #fff6f7;">

<!-- Spinner -->
<div id="spinner" class="fixed top-0 left-0 w-full h-full flex items-center justify-center bg-white z-50 opacity-100 transition-opacity duration-300">
    <div class="spinner rounded-full h-12 w-12 border-t-4 border-red-600"></div>
</div>

@include('components.navbar_guest')

<!-- Back to Top Button -->
<button class="back-to-top fixed bottom-8 right-8 p-3 rounded-xl transition-all opacity-200" style="color: #e63a28;">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- Hero Carousel -->
<section class="relative overflow-hidden bg-white " id="hero">
    <div class="header-carousel owl-carousel owl-theme">
        <!-- Slide 1 -->
        <div class="owl-carousel-item relative h-[400px] md:h-[600px]">
            <img src="{{ asset('storage/images/bb1.jpg') }}" 
                 class="w-full h-full object-cover" alt="Kids playing with toys">
            <div class="absolute inset-0 flex items-center bg-black/30">
                <div class="container mx-auto px-4">
                    <div class="max-w-2xl text-white">
                        <h1 class="text-3xl md:text-5xl font-bold mb-4 leading-tight">
                            Location de Jouets à Tétouan<br>
                            <span style="color: #e63a28;">Pour des Souvenirs Inoubliables</span>
                        </h1>
                        <p class="text-lg md:text-xl mb-6">
                            Découvrez notre collection de jouets premium pour tous les âges
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="#annonces" class="inline-block bg-white text-[#70e2d2] hover:bg-gray-100 px-6 py-3 rounded-full 
                            font-semibold transition-all duration-300 shadow-lg hover:shadow-xl">
                                Explorer Maintenant
                            </a>
                            <a href="#how-it-works" class="inline-block border-2 border-white text-white hover:bg-white/10 
                            px-6 py-3 rounded-full font-semibold transition-all duration-300">
                                Comment ça marche?
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="owl-carousel-item relative h-[400px] md:h-[600px]">
            <img src="{{ asset('storage/images/bb2.jpg') }}" 
                 class="w-full h-full object-cover" alt="Kids playing with Lego">
            <div class="absolute inset-0 flex items-center bg-black/30">
                <div class="container mx-auto px-4">
                    <div class="max-w-2xl text-white">
                        <h1 class="text-3xl md:text-5xl font-bold mb-4 leading-tight">
                            Des Jouets Éducatifs<br>
                            <span class="text-[#e63a28]">Pour Développer la Créativité</span>
                        </h1>
                        <p class="text-lg md:text-xl mb-6">
                            Apprentissage par le jeu avec nos sélections expertes
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="#categories" class="inline-block bg-white text-[#70e2d2] hover:bg-gray-100 px-6 py-3 
                            rounded-full font-semibold transition-all duration-300 shadow-lg hover:shadow-xl">
                                Parcourir les Catégories
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Arrows -->
    <div class="owl-nav custom-nav">
        <button class="owl-prev absolute left-4 top-1/2 -translate-y-1/2 bg-white/30 hover:bg-white/40 p-3 
        rounded-full transition-all duration-300">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <button class="owl-next absolute right-4 top-1/2 -translate-y-1/2 bg-white/30 hover:bg-white/40 p-3 
        rounded-full transition-all duration-300">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </div>
</section>


<!-- How It Works -->
<section class="py-20 bg-white" id="how-it-works">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mx-auto mb-16 wow fadeIn" data-wow-delay="0.1s">
            <h2 class="text-3xl font-bold text-black-900 mb-4">Comment ça marche?</h2>
            <p class="text-black-600 max-w-2xl mx-auto">Louez des jouets pour vos enfants en quelques étapes simples</p>
        </div>

        <div class="row g-8 grid md:grid-cols-4 gap-8">
            <!-- Step 1: Cold Red -->
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="facility-item group relative">
                    <div class="facility-icon bg-[#FDE2E4] rounded-full w-24 h-24 mx-auto flex items-center justify-center relative transition-all duration-300">
                        <span class="absolute left-0 top-1/2 -translate-y-1/2 w-3 h-6 bg-[#B23A48] rounded-full"></span>
                        <i class="fa fa-search fa-3x text-[#B23A48] group-hover:text-white"></i>
                        <span class="absolute right-0 top-1/2 -translate-y-1/2 w-3 h-6 bg-[#B23A48] rounded-full"></span>
                    </div>
                    <div class="facility-text bg-[#FDE2E4] mt-6 rounded-2xl p-8 text-center transition-all duration-300 group-hover:bg-[#B23A48] h-64 flex items-center justify-center">
                        <div>
                            <h3 class="text-xl font-bold text-[#B23A48] mb-3 group-hover:text-white">Trouvez le jouet</h3>
                            <p class="text-gray-600 group-hover:text-white">Parcourez notre sélection de jouets disponibles près de chez vous</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Cold Green -->
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="facility-item group relative">
                    <div class="facility-icon bg-[#D5EEDC] rounded-full w-24 h-24 mx-auto flex items-center justify-center relative transition-all duration-300">
                        <span class="absolute left-0 top-1/2 -translate-y-1/2 w-3 h-6 bg-[#4A7C59] rounded-full"></span>
                        <i class="fa fa-calendar-check fa-3x text-[#4A7C59] group-hover:text-white"></i>
                        <span class="absolute right-0 top-1/2 -translate-y-1/2 w-3 h-6 bg-[#4A7C59] rounded-full"></span>
                    </div>
                    <div class="facility-text bg-[#D5EEDC] mt-6 rounded-2xl p-8 text-center transition-all duration-300 group-hover:bg-[#4A7C59] h-64 flex items-center justify-center">
                        <div>
                            <h3 class="text-xl font-bold text-[#4A7C59] mb-3 group-hover:text-white">Réservez en ligne</h3>
                            <p class="text-gray-600 group-hover:text-white">Choisissez vos dates et effectuez le paiement sécurisé</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Cold Blue -->
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="facility-item group relative">
                    <div class="facility-icon bg-[#D6EAF8] rounded-full w-24 h-24 mx-auto flex items-center justify-center relative transition-all duration-300">
                        <span class="absolute left-0 top-1/2 -translate-y-1/2 w-3 h-6 bg-[#2874A6] rounded-full"></span>
                        <i class="fa fa-car-side fa-3x text-[#2874A6] group-hover:text-white"></i>
                        <span class="absolute right-0 top-1/2 -translate-y-1/2 w-3 h-6 bg-[#2874A6] rounded-full"></span>
                    </div>
                    <div class="facility-text bg-[#D6EAF8] mt-6 rounded-2xl p-8 text-center transition-all duration-300 group-hover:bg-[#2874A6] h-64 flex items-center justify-center">
                        <div>
                            <h3 class="text-xl font-bold text-[#2874A6] mb-3 group-hover:text-white">Récupération</h3>
                            <p class="text-gray-600 group-hover:text-white">Retirez le jouet chez le partenaire ou optez pour la livraison</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 4: Cold Yellow -->
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="facility-item group relative">
                    <div class="facility-icon bg-[#FEF9E7] rounded-full w-24 h-24 mx-auto flex items-center justify-center relative transition-all duration-300">
                        <span class="absolute left-0 top-1/2 -translate-y-1/2 w-3 h-6 bg-[#B7950B] rounded-full"></span>
                        <i class="fa fa-smile-beam fa-3x text-[#B7950B] group-hover:text-white"></i>
                        <span class="absolute right-0 top-1/2 -translate-y-1/2 w-3 h-6 bg-[#B7950B] rounded-full"></span>
                    </div>
                    <div class="facility-text bg-[#FEF9E7] mt-6 rounded-2xl p-8 text-center transition-all duration-300 group-hover:bg-[#B7950B] h-64 flex items-center justify-center">
                        <div>
                            <h3 class="text-xl font-bold text-[#B7950B] mb-3 group-hover:text-white">Profitez</h3>
                            <p class="text-gray-600 group-hover:text-white">Amusez-vous puis retournez le jouet en bon état</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Cards Section -->
<section id="annonces" class="py-20" style="background-color: rgb(112, 226, 210);">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-4xl font-bold text-center mb-16 text-gray-800 wow fadeIn">Découvrez Nos Jouets</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach ($objet->take(3) as $objet)
                @php
                    $annonce = $objet->annonces->first();
                    $etatColors = [
                        'Neuf' => 'bg-green-100 text-green-800',
                        'Bon état' => 'bg-blue-100 text-blue-800',
                        'Usage' => 'bg-amber-100 text-amber-800'
                    ];
                @endphp
             @if($annonce)
                <a href="{{ route('annonceID', ['id' => $annonce->id]) }}" 
                   class="group relative block bg-white rounded-xl shadow-md hover:shadow-md transition-all duration-300 overflow-hidden wow fadeInUp">
                    <div class="relative h-72 overflow-hidden">
                        @if ($objet->images->first())
                            <img src="{{ asset('storage/' . $objet->images->first()->url) }}"  
                                 class="w-full h-full object-cover transition-transform duration-100 group-hover:scale-105"
                                 alt="{{ $objet->nom }}">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center">
                                <i class="fas fa-image fa-3x text-black-300"></i>
                            </div>
                        @endif

                        @if ($annonce->premium)
                        <div class="absolute top-4 right-4 flex items-center bg-gradient-to-r from-amber-400 to-amber-500 px-3 py-1 rounded-full shadow-sm">
                            <span class="text-xs font-medium text-white">Premium</span>
                        </div>
                        @endif
                    </div>

                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-bold text-gray-900 truncate">{{ $objet->nom }}</h3>
                            <div class="text-right">
                                <span class="block text-2xl font-bold text-emerald-600">{{ $annonce->prix_journalier }} DH</span>
                                <span class="text-sm text-gray-500">par jour</span>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 rounded-full text-sm {{ $etatColors[$objet->etat] }}">
                                {{ ucfirst($objet->etat) }}
                            </span>
                            <span class="px-3 py-1 rounded-full bg-purple-100 text-purple-800 text-sm">
                                {{ $objet->tranche_age }} ans
                            </span>
                        </div>

                        <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                            {{ Str::limit($objet->description, 120) }}
                        </p>

                        <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt mr-2 text-gray-500"></i>
                                {{ $objet->ville }}
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-clock mr-2 text-gray-500"></i>
                                {{ $annonce->date_publication->diffForHumans() }}
                            </div>
                        </div>
                    </div>

                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <span class="inline-flex items-center text-white font-semibold bg-white/20 backdrop-blur-sm px-6 py-2 rounded-full border-2 border-white/30">
                            Voir détails
                            <i class="fas fa-arrow-right ml-2"></i>
                        </span>
                    </div>
                </a>
                 @endif
            @endforeach
        </div>

        <div class="text-center mt-12 wow fadeIn" data-wow-delay="0.2s">
            <a href="{{ route('annonces') }}" 
               class="inline-flex items-center px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                Explorer tous les jouets
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Devenir Partenaire -->
<section class="py-20" style="background-color: rgb(255, 242, 79);">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <!-- Image Section -->
                <div class="wow fadeIn" data-wow-delay="0.1s">
                    <div class="h-96 lg:h-full">
                        <img src="https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca" 
                             class="w-full h-full object-cover"
                             alt="Partenaire avec des jouets">
                    </div>
                </div>

                <!-- Content Section -->
                <div class="wow fadeIn" data-wow-delay="0.3s">
                    <div class="h-full flex flex-col justify-center p-8 lg:p-12">
                        <h2 class="text-3xl font-bold text-black-900 mb-4">
                            Devenez Partenaire
                            <span class="block text-2xl mt-2" style="color: #e63a28;">
                            Partagez vos jouets, Gagnez de l'argent
                            </span>
                        </h2>
                        
                        <ul class="space-y-3 mb-6 text-gray-600">
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                Gestion simplifiée de vos annonces
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                Paiements sécurisés et réguliers
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                Support client dédié 24/7
                            </li>
                        </ul>

                        <a href="{{ route('login') }}" 
                        class="inline-flex items-center justify-center w-full lg:w-auto px-8 py-3 block rounded-lg font-medium " style="color: #e63a28;"
>
                            Commencer maintenant
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-20" id="team">
  <div class="max-w-7xl mx-auto px-4">
    <div class="text-center mb-12">
      <h2 class="text-3xl font-bold text-gray-900 mb-4">Notre Équipe</h2>
      <p class="text-gray-600 max-w-2xl mx-auto">
        L'équipe derrière votre plateforme de location de jouets
      </p>
    </div>

    <!-- Swiper -->
    <div class="swiper mySwiper">
      <div class="swiper-wrapper">

        <!-- Team Members -->
        <div class="swiper-slide text-center p-4">
          <img src="{{ asset('storage/team/Kharchafi Mohammed.jpg') }}"
               class="rounded-full w-40 h-40 mx-auto object-cover mb-4" alt="Kharchafi Mohamed">
          <h3 class="font-semibold text-lg">Kharchafi Mohamed</h3>
          <p class="text-gray-600">Chef de Projet</p>
          <a href="https://github.com/kharchafi7005" class="text-gray-900 text-xl mt-2 inline-block">
            <i class="fab fa-github"></i>
          </a>
        </div>

        <div class="swiper-slide text-center p-4">
        <img src="{{ asset('storage/team/Mohamed Sadki.jpg') }}"  class="rounded-full w-40 h-40 mx-auto object-cover mb-4" alt="Sadki Mohamed">
        <h3 class="font-semibold text-lg">Sadki Mohamed</h3>
          <p class="text-gray-600">Client Team Lead</p>
          <a href="https://github.com/Skidis17" class="text-gray-900 text-xl mt-2 inline-block">
            <i class="fab fa-github"></i>
          </a>
        </div>

        <div class="swiper-slide text-center p-4">
           <img src="{{ asset('storage/team/BENSADDIK-Mohamed.jpg') }}" 
               class="rounded-full w-40 h-40 mx-auto object-cover mb-4" alt="Benseddik Mohamed">
          <h3 class="font-semibold text-lg">Benseddik Mohamed</h3>
          <p class="text-gray-600">Partenaire Lead</p>
          <a href="https://github.com/MedBens02" class="text-gray-900 text-xl mt-2 inline-block">
            <i class="fab fa-github"></i>
          </a>
        </div>

        <div class="swiper-slide text-center p-4">
          <img src="{{ asset('storage/team/Nada El mourabet.jpg') }}" 
               class="rounded-full w-40 h-40 mx-auto object-cover mb-4" alt="Nada El Mourabet">
          <h3 class="font-semibold text-lg">Nada El Mourabet</h3>
          <p class="text-gray-600"> Développeuse Frontend</p>
          <a href="https://github.com/ELMOURABETNADA" class="text-gray-900 text-xl mt-2 inline-block">
            <i class="fab fa-github"></i>
          </a>
        </div>

        <div class="swiper-slide text-center p-4">
          <img src="{{ asset('storage/team/Assiya El Ouazgany.jpg') }}" 
               class="rounded-full w-40 h-40 mx-auto object-cover mb-4" alt="El Ouazgani Assia">
          <h3 class="font-semibold text-lg">Assiya El Ouazgany</h3>
          <p class="text-gray-600">UI/UX Designer</p>
          <a href="https://github.com/assiyaelouazgany" class="text-gray-900 text-xl mt-2 inline-block">
            <i class="fab fa-github"></i>
          </a>
        </div>

        <div class="swiper-slide text-center p-4">
           <img src="{{ asset('storage/team/Houda El Bekkari.jpg') }}" 
               class="rounded-full w-40 h-40 mx-auto object-cover mb-4" alt="Houda el Bekkari">
          <h3 class="font-semibold text-lg">Houda el Bekkari</h3>
          <p class="text-gray-600">Admin Lead</p>
          <a href="https://github.com/Houda-El-Bekkari" class="text-gray-900 text-xl mt-2 inline-block">
            <i class="fab fa-github"></i>
          </a>
        </div>
        <div class="swiper-slide text-center p-4">
          <img src="{{ asset('storage/team/Chaymae El fahssi.jpg') }}" 
               class="rounded-full w-40 h-40 mx-auto object-cover mb-4" alt="Chaimae El Fahssi">
          <h3 class="font-semibold text-lg">Chaimae El Fahssi</h3>
          <p class="text-gray-600">Backend Developer</p>
          <a href="https://github.com/chaymae01" class="text-gray-900 text-xl mt-2 inline-block">
            <i class="fab fa-github"></i>
          </a>
        </div>

      </div>

      <!-- Pagination & Navigation -->
      <div class="swiper-pagination mt-6" style="color: #e63a28;"></div>
      <div class="swiper-button-prev" style="color: #e63a28;"></div>
      <div class="swiper-button-next" style="color: #e63a28;"></div>
    </div>
  </div>
</section>




<!-- Testimonials -->
<section class="py-20 bg-white" id="testimonials">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 wow fadeIn">Avis de nos clients</h2>
        <div class="testimonial-carousel owl-carousel owl-theme">
            @forelse($testimonials as $testimonial)
            <div class="item p-6">
                <div class="bg-gray-50 p-8 rounded-xl h-full">
                    <!-- Rating Stars -->
                    <div class="flex mb-4">
                        @for($i = 1; $i <= 5; $i++)
                        <svg class="w-5 h-5 {{ $i <= $testimonial->note ? 'text-amber-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        @endfor
                    </div>
                    
                    <p class="text-gray-600 mb-4 italic">"{{ $testimonial->commentaire }}"</p>
                    
                    <div class="flex items-center">
                        
                        <div class="w-12 h-12 rounded-full bg-red-600 text-white flex items-center justify-center mr-4">
                            {{ substr($testimonial->client->nom, 0, 2) }}
                        </div>
         
                        
                        <div>
                            <h4 class="font-semibold">{{ $testimonial->client->name }}</h4>
                            <p class="text-sm text-gray-500">
                                {{ $testimonial->created_at ? $testimonial->created_at->diffForHumans() : 'N/A'
                                }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="item p-6">
                <div class="bg-gray-50 p-8 rounded-xl text-center">
                    <p class="text-gray-600">Aucun avis disponible pour le moment</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>


<!-- Footer -->
<footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid md:grid-cols-4 gap-8">
            <div class="space-y-4">
                <img src="{{ asset('images/lo3baty.jpg') }}" class="h-16 w-auto mb-4" alt="Logo">
                <p class="text-gray-400">La solution simple et pratique pour louer des jouets à Tétouan</p>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">Navigation</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('acceuil') }}" class="text-gray-400 hover:text-white">Accueil</a></li>
                    <li><a href="{{ route('annonces') }}" class="text-gray-400 hover:text-white">Annonces</a></li>
                    <li><a href="{{ route('acceuil') }}" class="text-gray-400 hover:text-white">À propos</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">Contact</h4>
                <ul class="space-y-2">
                    <li class="text-gray-400">lo3baty1@gmail.com</li>
                    <li class="text-gray-400">+212 6 12 34 56 78</li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">Suivez-nous</h4>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-facebook fa-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-instagram fa-lg"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-twitter fa-lg"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
            &copy; {{ now()->year }} Jouets Tétouan. Tous droits réservés.
        </div>
    </div>
</footer>


<!-- JavaScript Dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
(function ($) {
    "use strict";

    // Initialize WOW.js
    new WOW({ offset: 50 }).init();

    // Spinner
    $(window).on('load', function() {
        $('#spinner').fadeOut(500);
    });

    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.sticky-top').addClass('shadow-sm').css('top', '0px');
        } else {
            $('.sticky-top').removeClass('shadow-sm').css('top', '-100px');
        }
    });
    
    // Back to top
    $(window).scroll(function () {
        $('.back-to-top')[$(this).scrollTop() > 300 ? 'fadeIn' : 'fadeOut']('slow');
    }).trigger('scroll');
    
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1000);
        return false;
    });

    // Carousels
    $(".header-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        items: 1,
        dots: true,
        loop: true,
        nav: true,
        navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>']
    });

    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 24,
        dots: false,
        loop: true,
        nav: true,
        responsive: {
            0: { items: 1 },
            992: { items: 2 }
        },
        navText: ['<i class="fas fa-arrow-left"></i>', '<i class="fas fa-arrow-right"></i>']
    });

})(jQuery);
</script>
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Swiper Init -->
<script>
  const swiper = new Swiper('.mySwiper', {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    breakpoints: {
      640: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 3,
      },
      1024: {
        slidesPerView: 4,
      },
    },
  });
</script>

</body>
</html>