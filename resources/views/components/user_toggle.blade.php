<div class="flex items-center gap-4" x-data="{ 
    userMenuOpen: false, 
    toggleUserType() {
        this.isPartner = !this.isPartner;
        window.location.href = this.isPartner ? '' : ;
    }
}">
    <!-- User Type Toggle -->
    <div class="flex rounded-lg bg-gray-100 p-1">
        <button 
            @click="!isPartner ? null : toggleUserType()"
            :class="!isPartner ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'"
            class="px-4 py-1.5 text-sm font-medium rounded-md transition-colors"
        >
            Client
        </button>
        <button 
            @click="isPartner ? null : toggleUserType()"
            :class="isPartner ? 'bg-white shadow-sm text-blue-600' : 'text-gray-500'"
            class="px-4 py-1.5 text-sm font-medium rounded-md transition-colors"
        >
            Partenaire
        </button>
    </div>

    <!-- Profile Dropdown -->
    <div class="relative">
        <button 
            @click="userMenuOpen = !userMenuOpen"
            class="flex items-center gap-2 hover:bg-gray-50 rounded-full p-1 pr-2 transition-colors"
        >
            <img src="" alt="Avatar" class="w-8 h-8 rounded-full object-cover">
            <span class="text-sm font-medium text-gray-700"></span>
            <svg :class="" class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <!-- Dropdown Menu -->
        <div 
            x-show="userMenuOpen"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            @click.outside="userMenuOpen = false"
            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-50"
        >
            <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                Mon Profil
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                    Déconnexion
                </button>
            </form>
        </div>
    </div>
</div>