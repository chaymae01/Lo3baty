
<script src="https://unpkg.com/lucide@latest"></script>
<div class="w-64 min-h-screen bg-gradient-to-r from-blue-300 to-blue-500 text-white border-r shadow-lg px-6 py-8">
    <!-- Logo extra large dans un cercle blanc sophistiqué -->
    <div class="flex justify-center mb-12">
        <div class="bg-white p-3 rounded-full shadow-xl border-4 border-blue-100 
                   hover:scale-105 transition-all duration-300 flex items-center justify-center"
             style="width: 150px; height: 150px;">
            <img src="{{ asset('images/logo1.png') }}" alt="Logo"
                 class="h-28 w-28 object-contain">
        </div>
    </div>
    <ul class="space-y-6 text-lg">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-300 flex items-center space-x-3 transition-colors duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10l9-7 9 7v10a2 2 0 01-2 2h-4a2 2 0 01-2-2V14H9v6a2 2 0 01-2 2H3a2 2 0 01-2-2V10z" />
                </svg>
                <span>Tableau de Bord</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.partenaires') }}" class="hover:text-blue-300 flex items-center space-x-3 transition-colors duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span>Partenaires</span>
            </a>
        </li>
       
        <li>
            <a href="{{ route('admin.clients') }}" class="hover:text-blue-300 flex items-center space-x-3 transition-colors duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span>Cleints</span>
            </a>
        </li>
        <li>
    <a href="{{ route('admin.annonces.index') }}" class="hover:text-purple-300 flex items-center space-x-3 transition-colors duration-300">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
        </svg>
        <span>Annonces</span>
    </a>
<li>
    <a href="{{ route('admin.categories.index') }}" class="hover:text-blue-300 flex items-center space-x-3 transition-colors duration-300">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <span>Catégories</span>
    </a>
    
</li>
        <li>
    <a href="{{ route('admin.reservations.index') }}" class="hover:text-blue-300 flex items-center space-x-3 transition-colors duration-300">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <span>Réservations</span>
    </a>
</li>
       
        <li>
    <a href="{{ route('admin.paiements') }}" 
    class="hover:text-blue-300 flex items-center space-x-3 transition-colors duration-300">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <span>Paiements</span>
    </a>
</li>
</li>
            <a href="{{ route('admin.reclamations.index') }}" class="hover:text-blue-300 flex items-center space-x-3 transition-colors duration-300">
                  <i data-lucide="file-warning" class="w-5 h-5"></i>
                  <span>Reclamations</span>
            </a>
        <li>
        <li>
    <a href="{{ route('admin.commentaires') }}" class="hover:text-purple-300 flex items-center space-x-3 transition-colors duration-300">
        <i data-lucide="message-square-dashed" class="w-5 h-5"></i>
        <span>Commentaires</span>
    </a>
</li>
        <li>
            <form method="POST" action="{{ route('admin.Adminlogout') }}" class="inline">
                @csrf
                <button type="submit" class="w-full text-red-400 hover:text-red-500 hover:underline flex items-center space-x-3 transition-colors duration-300">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    <span>Déconnexion</span>
                </button>
            </form>
        </li>
    </ul>
    <div class="mt-12 text-xs text-gray-300 text-center">
        Lo3baty - Espace Admin<br>
        Made with 
    </div>
</div>

<script>
    lucide.createIcons(); // Initialisation des icônes
</script>