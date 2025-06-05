<nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo - Enhanced with hover effect -->
            <a href="{{ route('acceuil') }}" class="flex-shrink-0 transition-transform hover:scale-105">
                <img src="{{ asset('images/lo3baty.jpg') }}" alt="Logo" class="h-9 w-auto rounded-lg shadow-sm">
            </a>

            <!-- Navigation Links - Improved spacing and hover effects -->
            <div class="hidden md:flex items-center space-x-8 ml-10">
                <a href="{{ route('acceuil') }}" class="relative px-3 py-2 text-sm font-medium text-gray-700 hover:text-red-600 transition-colors duration-200">
                    <span class="relative group">
                        Accueil
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-red-600 transition-all duration-300 group-hover:w-full"></span>
                    </span>
                </a>
                
                <a href="{{ route('annonces') }}" class="relative px-3 py-2 text-sm font-medium text-gray-700 hover:text-red-600 transition-colors duration-200">
                    <span class="relative group">
                        Annonces
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-red-600 transition-all duration-300 group-hover:w-full"></span>
                    </span>
                </a>
                
                <a href="{{ route('reservations') }}" class="relative px-3 py-2 text-sm font-medium text-gray-700 hover:text-red-600 transition-colors duration-200">
                    <span class="relative group">
                        Réservations
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-red-600 transition-all duration-300 group-hover:w-full"></span>
                    </span>
                </a>
            </div>

            <!-- User Section - Better alignment -->
            <div class="flex items-center gap-4">
                @include('components.user_toggle')
            </div>
        </div>
    </div>
</nav>