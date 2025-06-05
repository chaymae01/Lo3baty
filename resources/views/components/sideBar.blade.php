<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lo3baty Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes ping {
            75%, 100% { transform: scale(1.5); opacity: 0; }
        }
        .animate-ping-once { animation: ping 1s cubic-bezier(0, 0, 0.2, 1) 1; }
        
        .profile-modal {
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        .profile-modal-content {
            transform: translateY(-20px);
            transition: transform 0.3s ease;
        }
        .profile-modal.active {
            opacity: 1;
            visibility: visible;
        }
        .profile-modal.active .profile-modal-content {
            transform: translateY(0);
        }
        .profile-tab-content {
            display: none;
        }
        .profile-tab-content.active {
            display: block;
        }
        @keyframes ping {
        0% { transform: scale(1); opacity: 1; }
        75%, 100% { transform: scale(1.5); opacity: 0; }
        }
       .animate-ping-once {
       animation: ping 1s cubic-bezier(0, 0, 0.2, 1) 1;
    }

    .toggle-checkbox {
    appearance: none;
    width: 3rem;
    height: 1.5rem;
    background-color: #e2e8f0;
    border-radius: 9999px;
    position: relative;
    cursor: pointer;
    transition: background-color 0.2s;
}
.toggle-checkbox:checked {
    background-color: #3b82f6;
}
.toggle-checkbox::before {
    content: '';
    position: absolute;
    width: 1.25rem;
    height: 1.25rem;
    background-color: white;
    border-radius: 9999px;
    top: 0.125rem;
    left: 0.125rem;
    transition: transform 0.2s;
}
.toggle-checkbox:checked::before {
    transform: translateX(1.5rem);
}
    </style>
</head>
<body class="font-sans bg-gray-50">
    <header class="bg-white shadow-sm sticky top-0 z-50">
        @if(session('success'))
<div 
    x-data="{ show: true }" 
    x-show="show" 
    x-transition 
    x-init="setTimeout(() => show = false, 4000)" 
    class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50"
>
    <span class="font-semibold">{{ session('success') }}</span>
    <button @click="show = false" class="ml-4 text-white hover:text-gray-100">&times;</button>
</div>
@endif
        <div class="container mx-auto px-6">
            <div class="flex items-center justify-between h-16">
               <div class="flex items-center">
    <a href="{{ url('/') }}">
    <img src="{{ asset('storage/images/Lo3baty.jpg') }}" alt="Lo3baty Logo" class="h-10 w-auto ml-6 border-rounded">
    </a>
    </div>

               <nav class="hidden md:flex items-center space-x-8">
    
    <a href="{{ route('annonces') }}" class="relative group text-gray-600 hover:text-[#e63a28] transition-colors">
        Annonces
        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#e63a28] group-hover:w-full transition-all duration-300"></span>
    </a>
    <a href="{{ route('stats') }}" class="relative group text-gray-600 hover:text-[#e63a28] transition-colors">
        Statistiques
        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#e63a28] group-hover:w-full transition-all duration-300"></span>
    </a>
    <a href="{{ route('reservations') }}" class="relative group text-gray-600 hover:text-[#e63a28] transition-colors">
        Mes réservations
        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#e63a28] group-hover:w-full transition-all duration-300"></span>
    </a>
    <a href="{{ route('reclamations') }}" class="relative group text-gray-600 hover:text-[#e63a28] transition-colors">
        Mes Réclamations
        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#e63a28] group-hover:w-full transition-all duration-300"></span>
    </a>
</nav>



               <div class="flex items-center space-x-4">
    <div class="bg-gradient-to-r from-[#e63a28] to-[#e63a28] p-0.5 rounded-full shadow-inner mr-2">
        <div class="flex relative">
            <button onclick="switchRole('client')" 
                    class="px-4 py-1 text-sm font-medium rounded-full bg-white text-[#e63a28] shadow-sm z-10 transition-all duration-300 mr-1"
                    :class="{ 'bg-white text-[#e63a28]': currentRole === 'client', 'text-white': currentRole !== 'client' }">
                Client
            </button>
            <button onclick="switchRole('partenaire')" 
                    class="px-4 py-1 text-sm font-medium rounded-full transition-all duration-300"
                    :class="{ 'bg-white text-[#e63a28]': currentRole === 'partenaire', 'text-white': currentRole !== 'partenaire' }">
                Partenaire
            </button>
        </div>
    </div>

                    
                    <div class="relative">
                        <button id="annonceNotificationButton" class="p-2 rounded-full hover:bg-gray-100 transition-colors relative">
                            <i class="fas fa-bullhorn text-gray-600 text-xl"></i>
                            @if(auth()->user()->notification_annonce !== 'desactive')
    @php
        $annonceNotificationsCount = auth()->user()->unreadNotifications
            ->whereIn('data.type', ['nouvelle_annonce', 'annonce_modifiee'])
            ->count();
    @endphp
    @if($annonceNotificationsCount > 0)
    <span id="annonceNotificationBadge" class="absolute top-0 right-0 w-5 h-5 bg-green-500 text-white text-xs rounded-full flex items-center justify-center transform translate-x-1/2 -translate-y-1/2">
        {{ $annonceNotificationsCount > 9 ? '9+' : $annonceNotificationsCount }}
    </span>
    @endif
@endif
                        </button>

                        <div id="annonceNotificationDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg z-50 border border-gray-200 divide-y divide-gray-200">
                            <div class="p-3 flex justify-between items-center bg-gray-50 rounded-t-md">
                                <h3 class="font-medium text-gray-800">Notifications d'annonces</h3>
                                <button id="markAnnonceAsRead" class="text-xs text-blue-600 hover:underline">Tout marquer comme lu</button>
                            </div>
                              <button id="notificationSettingsBtn" class="w-full px-4 py-3 text-left border-b border-gray-200 hover:bg-gray-50 transition-colors flex items-center">
        <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center mr-3">
            <i class="fas fa-cog text-blue-500 text-sm"></i>
        </div>
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-800">Paramètres de notification</p>
            <p class="text-xs text-gray-500 mt-1">Gérer vos préférences</p>
        </div>
        <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
    </button>
                            <div id="annonceNotificationList" class="max-h-96 overflow-y-auto">
                                @php
                                    $annonceNotifications = auth()->user()->notifications
                                        ->whereIn('data.type', ['nouvelle_annonce', 'annonce_modifiee'])
                                        ->take(10);
                                @endphp
                                @forelse($annonceNotifications as $notification)
                                    <div class="block p-3 hover:bg-gray-50 transition-colors duration-150 {{ $notification->unread() ? 'bg-green-50' : '' }}">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 pt-0.5">
                                                @if($notification->data['type'] == 'annonce_modifiee')
                                                    <i class="fas fa-edit text-purple-500"></i>
                                                @else
                                                    <i class="fas fa-bullhorn text-green-500"></i>
                                                @endif
                                            </div>
                                            <div class="ml-3 flex-1 min-w-0">
                                                <p class="font-medium text-gray-800">
                                                    @if($notification->data['type'] == 'annonce_modifiee')
                                                        Annonce modifiée
                                                    @else
                                                        Nouvelle annonce
                                                    @endif
                                                </p>
                                                <p class="text-sm text-gray-600 mt-1">
                                                    {{ $notification->data['message'] ?? '' }}
                                                </p>
                                                @if(isset($notification->data['titre']))
                                                    <p class="text-xs text-gray-700 mt-1 bg-gray-100 p-1 rounded">
                                                        <strong>Titre:</strong> {{ $notification->data['titre'] }}
                                                    </p>
                                                @endif
                                                <p class="text-xs text-gray-500 mt-2 flex items-center">
                                                    <i class="far fa-clock mr-1"></i>
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </p>
                                                <a href="{{ $notification->data['url'] ?? '#' }}" class="mt-2 inline-block px-3 py-1 bg-blue-600 text-white text-xs rounded-full hover:bg-blue-700 transition-colors">
                                                    Détails
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-6 text-center text-gray-400">
                                        <i class="far fa-bell-slash text-2xl mb-2"></i>
                                        <p class="text-sm">Aucune notification d'annonce</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

<div id="notificationSettingsModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Paramètres de notification</h3>
                <button id="notificationSettingsBtn" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors flex items-center">
        <i class="fas fa-bell-slash mr-2 text-gray-500"></i>
        <span>Paramètres de notification</span>
        <i class="fas fa-cog ml-auto text-gray-400"></i>
    </button>

        </div>
        
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <label for="disableAnnonceNotifications" class="text-gray-700">Désactiver les notifications de nouvelles annonces</label>
                <input type="checkbox" id="disableAnnonceNotifications" class="toggle-checkbox">
            </div>
        </div>
        
        <div class="mt-6 flex justify-end space-x-3">
            <button onclick="document.getElementById('notificationSettingsModal').classList.add('hidden')" class="px-4 py-2 border rounded-md">
                Annuler
            </button>
            <button id="saveNotificationSettings" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                Enregistrer
            </button>
        </div>
    </div>
</div>


                    <div class="relative">
                        <button id="notificationButton" class="p-2 rounded-full hover:bg-gray-100 transition-colors relative">
                            <i class="fas fa-bell text-gray-600 text-xl"></i>
                            @php
                                $otherNotificationsCount = auth()->user()->unreadNotifications
                                    ->whereNotIn('data.type', ['nouvelle_annonce', 'annonce_modifiee'])
                                    ->count();
                            @endphp
                            @if($otherNotificationsCount > 0)
                            <span id="notificationBadge" class="absolute top-0 right-0 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center transform translate-x-1/2 -translate-y-1/2">
                                {{ $otherNotificationsCount > 9 ? '9+' : $otherNotificationsCount }}
                            </span>
                            @endif
                        </button>

                        <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg z-50 border border-gray-200 divide-y divide-gray-200">
                            <div class="p-3 flex justify-between items-center bg-gray-50 rounded-t-md">
                                <h3 class="font-medium text-gray-800">Notifications</h3>
                                <button id="markAllAsRead" class="text-xs text-blue-600 hover:underline">Tout marquer comme lu</button>
                            </div>
                            
                            <div id="notificationList" class="max-h-96 overflow-y-auto">
                                @php
                                    $otherNotifications = auth()->user()->notifications
                                        ->whereNotIn('data.type', ['nouvelle_annonce', 'annonce_modifiee'])
                                        ->take(10);
                                @endphp
                                @forelse($otherNotifications as $notification)
                                <div class="block p-3 hover:bg-gray-50 transition-colors duration-150 {{ $notification->unread() ? 'bg-blue-50' : '' }}"
                                   data-notification='@json($notification)'>
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 pt-0.5">
                                            @if($notification->data['type'] == 'reclamation_reponse')
                                                <i class="fas fa-reply text-blue-500"></i>
                                            @elseif($notification->data['type'] == 'reservation_expiration')
                                                <i class="fas fa-clock text-orange-500"></i>
                                            @else
                                                <i class="fas fa-bell text-gray-400"></i>
                                            @endif
                                        </div>
                                        <div class="ml-3 flex-1 min-w-0">
                                            @if($notification->data['type'] == 'reservation_expiration')
                                                <p class="font-medium text-gray-800">Réservation expirante</p>
                                                <p class="text-sm text-gray-600 mt-1">
                                                    Une de vos réservations expire bientôt
                                                </p>
                                                <p class="text-xs text-orange-600 mt-1">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                                    Expire dans: {{ round(floatval(str_replace('Réservation se termine dans ', '', $notification->data['message'] ?? '0'))) }}h
                                                </p>
                                                <a href="{{ route('reservations') }}" class="mt-2 inline-block px-3 py-1 bg-blue-600 text-white text-xs rounded-full hover:bg-blue-700 transition-colors">
                                                Détails
                                            </a>
                                            @else
                                                <p class="font-medium text-gray-800">
                                                    @if($notification->data['type'] == 'reclamation_reponse')
                                                        Réponse à votre réclamation
                                                    @else
                                                        Notification
                                                    @endif
                                                </p>
                                               
                                                @if($notification->data['type'] == 'reclamation_reponse')
                                                    <p class="text-xs text-gray-700 mt-1 bg-gray-100 p-1 rounded">
                                                        <strong>Sujet:</strong> {{ $notification->data['sujet'] ?? '' }}
                                                    </p>

                                                    <a href="{{ route('reclamations') }}" class="mt-2 inline-block px-3 py-1 bg-blue-600 text-white text-xs rounded-full hover:bg-blue-700 transition-colors">
                                                Détails
                                            </a>
                                                @endif
                                            @endif
                                            
                                            <p class="text-xs text-gray-500 mt-2 flex items-center">
                                                <i class="far fa-clock mr-1"></i>
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                            
                                        </div>
                                    </div>
                                </div>
                                @empty
                                    <div class="p-6 text-center text-gray-400">
                                        <i class="far fa-bell-slash text-2xl mb-2"></i>
                                        <p class="text-sm">Aucune notification disponible</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    
                  
              <div class="relative inline-block text-left">
    <button id="menuButton" class="w-9 h-9 rounded-full overflow-hidden bg-gray-200 border-2 border-white">
    <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" 
            alt="User" class="w-full h-full object-cover" />
    </button>


    <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
        <button id="profileButton" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
            <i class="fas fa-cog mr-2 text-gray-500"></i> Paramètres
        </button>
        <form>
            @csrf
            <button type="submit" onclick="logout()" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                <i class="fas fa-sign-out-alt mr-2 text-gray-500"></i> Déconnexion
            </button>
        </form>
    </div>
</div>
                </div>
            </div>
        </div>
    </header>

<div id="profileModal" class="profile-modal fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 opacity-0 invisible">
    <div class="profile-modal-content bg-white rounded-lg shadow-xl w-full max-w-md overflow-hidden">
       
        <div class="bg-blue-500 p-4 text-white relative">
            <h2 class="text-xl font-bold">Mon Profil</h2>
            <button onclick="closeProfileModal()" class="absolute top-4 right-4 text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
       
        <div class="flex border-b">
            <button onclick="switchProfileTab('profile-tab')" class="profile-tab-btn flex-1 py-3 font-medium text-blue-500 border-b-2 border-blue-500">
                <i class="fas fa-user-circle mr-2"></i>Profil
            </button>
            <button onclick="switchProfileTab('password-tab')" class="profile-tab-btn flex-1 py-3 font-medium text-gray-500">
                <i class="fas fa-lock mr-2"></i>Mot de passe
            </button>
        </div>
        
      
<div id="profile-tab" class="profile-tab-content active p-6">
    <div class="flex flex-col items-center mb-6">
        <div class="relative mb-4">
            <img id="profile-image" 
                 src="{{ auth()->user()->image_profil ? asset('storage/' . auth()->user()->image_profil) : 'https://ui-avatars.com/api/?name='.auth()->user()->prenom.'+'.auth()->user()->nom.'&background=4f46e5&color=fff' }}" 
                 alt="Photo de profil" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow">
            <label for="image-upload" class="absolute bottom-0 right-0 bg-blue-500 text-white rounded-full p-2 cursor-pointer hover:bg-blue-600">
                <i class="fas fa-camera"></i>
                <input type="file" id="image-upload" accept="image/*" class="hidden">
            </label>
        </div>
        <h3 id="user-name" class="text-xl font-bold">{{ auth()->user()->prenom }} {{ auth()->user()->nom }}</h3>
        <p id="user-email" class="text-gray-600">{{ auth()->user()->email }}</p>
        @if(auth()->user()->surnom)
            <p id="user-surnom" class="text-gray-500 italic">"{{ auth()->user()->surnom }}"</p>
        @endif
    </div>
    
    <form id="profile-form" class="space-y-4">
        @csrf
        <div>
            <label for="user-nom" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
            <input type="text" id="user-nom" name="nom" value="{{ auth()->user()->nom }}" 
                   class="w-full p-2 border rounded focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="user-prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
            <input type="text" id="user-prenom" name="prenom" value="{{ auth()->user()->prenom }}" 
                   class="w-full p-2 border rounded focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label for="user-surnom" class="block text-sm font-medium text-gray-700 mb-1">Surnom (optionnel)</label>
            <input type="text" id="user-surnom" name="surnom" value="{{ auth()->user()->surnom }}" 
                   class="w-full p-2 border rounded focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Votre surnom">
        </div>
      
       
        <div id="profile-error" class="text-red-500 text-sm hidden"></div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
            <i class="fas fa-save mr-2"></i>Enregistrer les modifications
        </button>
    </form>
</div>
        <div id="password-tab" class="profile-tab-content p-6">
            <form id="password-form" class="space-y-4">
                @csrf
               
                <div>
                    <label for="new-password" class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                    <div class="relative">
                        <input type="password" id="new-password" name="new_password" class="w-full p-2 border rounded" required minlength="8">
                        <button type="button" class="absolute right-3 top-2 text-gray-500 toggle-password">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Minimum 8 caractères avec majuscules, minuscules, chiffres et symboles</p>
                </div>
                <div>
                    <label for="confirm-password" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                    <div class="relative">
                        <input type="password" id="confirm-password" name="new_password_confirmation" class="w-full p-2 border rounded" required>
                        <button type="button" class="absolute right-3 top-2 text-gray-500 toggle-password">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div id="password-error" class="text-red-500 text-sm hidden"></div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
                    <i class="fas fa-save mr-2"></i>Enregistrer
                </button>
            </form>
        </div>
        
        <div class="border-t p-4 flex justify-between">
            <button onclick="logout()" class="text-red-500 hover:text-red-700 flex items-center">
                <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
            </button>
            <button onclick="closeProfileModal()" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                Fermer
            </button>
        </div>
    </div>
</div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
    const profileButton = document.getElementById('profileButton');
    const profileModal = document.getElementById('profileModal');

    profileButton.addEventListener('click', function(e) {
        e.stopPropagation();
        openProfileModal();
    });

    function switchProfileTab(tabId) {
        document.querySelectorAll('.profile-tab-content').forEach(tab => {
            tab.classList.remove('active');
        });
    
        document.querySelectorAll('.profile-tab-btn').forEach(btn => {
            btn.classList.remove('text-blue-500', 'border-blue-500');
            btn.classList.add('text-gray-500');
        });

        document.getElementById(tabId).classList.add('active');
    
        event.currentTarget.classList.remove('text-gray-500');
        event.currentTarget.classList.add('text-blue-500', 'border-blue-500');
    }

    document.getElementById('image-upload').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
    
        const formData = new FormData();
        formData.append('image', file);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
    
        fetch('/profile/update-image', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('profile-image').src = data.image_url.startsWith('http') ? 
                    data.image_url : 
                    `/storage/${data.image_url}`;
                
                showToast('success', 'Image de profil mise à jour avec succès');
            } else {
                showToast('error', data.message || 'Erreur lors de la mise à jour de l\'image');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', 'Une erreur est survenue');
        });
    });

    document.getElementById('profile-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const errorElement = document.getElementById('profile-error');

    fetch('/profile/update-info', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('user-name').textContent = 
                `${formData.get('prenom')} ${formData.get('nom')}`;
            document.getElementById('user-email').textContent = formData.get('email');
            
            // Mise à jour du surnom dans l'affichage
            const surnom = formData.get('surnom');
            const surnomElement = document.getElementById('user-surnom');
            if (surnom) {
                if (!surnomElement) {
                    const emailElement = document.getElementById('user-email');
                    const newSurnomElement = document.createElement('p');
                    newSurnomElement.id = 'user-surnom';
                    newSurnomElement.className = 'text-gray-500 italic';
                    newSurnomElement.textContent = `"${surnom}"`;
                    emailElement.after(newSurnomElement);
                } else {
                    surnomElement.textContent = `"${surnom}"`;
                }
            } else if (surnomElement) {
                surnomElement.remove();
            }
            
            showToast('success', 'Profil mis à jour avec succès');
        } else {
            errorElement.textContent = data.message || 'Erreur lors de la mise à jour';
            errorElement.classList.remove('hidden');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        errorElement.textContent = 'Une erreur est survenue';
        errorElement.classList.remove('hidden');
    });
});

    document.getElementById('password-form').addEventListener('submit', function(e) {
        e.preventDefault();
    
        const formData = new FormData(this);
        const errorElement = document.getElementById('password-error');
    
        fetch('/profile/update-password', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.reset();
                errorElement.classList.add('hidden');
                showToast('success', 'Mot de passe mis à jour avec succès');
            } else {
                errorElement.textContent = data.message || 'Erreur lors de la mise à jour';
                errorElement.classList.remove('hidden');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            errorElement.textContent = 'Une erreur est survenue';
            errorElement.classList.remove('hidden');
        });
    });
 
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            const icon = this.querySelector('i');
            
            if(input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    function showToast(type, message) {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 px-4 py-2 rounded-md shadow-md text-white ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        }`;
        toast.textContent = message;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.add('opacity-0', 'transition-opacity', 'duration-300');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    profileModal.addEventListener('click', function(e) {
        if(e.target === this) {
            closeProfileModal();
        }
    });

    document.querySelector('.profile-modal-content').addEventListener('click', function(e) {
        e.stopPropagation();
    });
});

function openProfileModal() {
    const profileModal = document.getElementById('profileModal');
    profileModal.classList.add('active');
}

function closeProfileModal() {
    const profileModal = document.getElementById('profileModal');
    profileModal.classList.remove('active');
}

function switchProfileTab(tabId) {
    document.querySelectorAll('.profile-tab-content').forEach(tab => {
        tab.classList.remove('active');
    });
    
    document.querySelectorAll('.profile-tab-btn').forEach(btn => {
        btn.classList.remove('text-blue-500', 'border-blue-500');
        btn.classList.add('text-gray-500');
    });
    
    document.getElementById(tabId).classList.add('active');
    
    event.currentTarget.classList.remove('text-gray-500');
    event.currentTarget.classList.add('text-blue-500', 'border-blue-500');
}

document.addEventListener('DOMContentLoaded', function() {
    const profileButton = document.getElementById('profileButton');
    if (profileButton) {
        profileButton.addEventListener('click', function(e) {
            e.stopPropagation();
            openProfileModal();
        });
    }

    const profileModal = document.getElementById('profileModal');
    if (profileModal) {
        profileModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeProfileModal();
            }
        });

        const modalContent = document.querySelector('.profile-modal-content');
        if (modalContent) {
            modalContent.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
    }

    const closeButtons = document.querySelectorAll('[onclick="closeProfileModal()"]');
    closeButtons.forEach(button => {
        button.addEventListener('click', closeProfileModal);
    });
});

function logout() {
    fetch('/logout', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur lors de la déconnexion');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            window.location.href = '/'; 
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('error', error.message || 'Erreur lors de la déconnexion');
    });
}

function switchRole(role) {
    fetch('/switch-role', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ role: role })
    })
    .then(response => response.json())
    .then(data => {
        if (data.redirect) {
            if (data.completed === false) {
                window.location.href = data.redirect;
            } else {
                window.location.href = data.redirect;
            }
        } else if (data.success) {
            updateRoleUI(role);
        } else {
            showToast('error', data.message || 'Erreur lors du changement de rôle');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('error', 'Une erreur est survenue');
    });
}

function updateRoleUI(role) {
    const clientBtn = document.querySelector('button[onclick="switchRole(\'client\')"]');
    const partenaireBtn = document.querySelector('button[onclick="switchRole(\'partenaire\')"]');
    
    if (role === 'client') {
        clientBtn.classList.add('bg-white', 'text-blue-600');
        clientBtn.classList.remove('text-white');
        partenaireBtn.classList.add('text-white');
        partenaireBtn.classList.remove('bg-white', 'text-blue-600');
    } else {
        partenaireBtn.classList.add('bg-white', 'text-blue-600');
        partenaireBtn.classList.remove('text-white');
        clientBtn.classList.add('text-white');
        clientBtn.classList.remove('bg-white', 'text-blue-600');
    }
    
    showToast('success', `Vous êtes maintenant en mode ${role === 'client' ? 'Client' : 'Partenaire'}`);
}

document.addEventListener('DOMContentLoaded', function() {
    const annonceNotificationButton = document.getElementById('annonceNotificationButton');
    const annonceNotificationDropdown = document.getElementById('annonceNotificationDropdown');
    const annonceNotificationList = document.getElementById('annonceNotificationList');
    const markAnnonceAsRead = document.getElementById('markAnnonceAsRead');
    let annonceNotificationBadge = document.getElementById('annonceNotificationBadge');

    const notificationButton = document.getElementById('notificationButton');
    const notificationDropdown = document.getElementById('notificationDropdown');
    const notificationList = document.getElementById('notificationList');
    const markAllAsRead = document.getElementById('markAllAsRead');
    let notificationBadge = document.getElementById('notificationBadge');

    const notificationSettingsBtn = document.getElementById('notificationSettingsBtn');
    const notificationSettingsModal = document.getElementById('notificationSettingsModal');
    const disableAnnonceNotificationsToggle = document.getElementById('disableAnnonceNotifications');
    const saveNotificationSettingsBtn = document.getElementById('saveNotificationSettings');

    let hasUnreadAnnonceNotifications = false;
    let hasUnreadOtherNotifications = false;
    let notificationPreferences = {
        annonceDisabled: false
    };

    function showToast(type, message) {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 px-4 py-2 rounded-md shadow-md text-white ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        }`;
        toast.textContent = message;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.add('opacity-0', 'transition-opacity', 'duration-300');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

  function loadNotificationPreferences() {
    return fetch('/notification-preferences', {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Erreur de réseau');
        return response.json();
    })
    .then(data => {
        notificationPreferences = {
            annonceDisabled: data.annonce_disabled
        };
        
        if (disableAnnonceNotificationsToggle) {
            disableAnnonceNotificationsToggle.checked = data.annonce_disabled;
        }
        
        if (data.annonce_disabled && document.getElementById('annonceNotificationBadge')) {
            document.getElementById('annonceNotificationBadge').remove();
        }
        
        return data;
    })
    .catch(error => {
        console.error('Erreur:', error);
        showToast('error', 'Impossible de charger les préférences');
        return { annonce_disabled: false };
    });
}


 function saveNotificationPreferences() {
    const newPreference = {
        annonce_disabled: disableAnnonceNotificationsToggle.checked
    };

    return fetch('/notification-preferences', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(newPreference)
    })
    .then(response => {
        if (!response.ok) throw new Error('Erreur lors de la sauvegarde');
        return response.json();
    })
    .then(data => {
        if (data.success) {
            notificationPreferences.annonceDisabled = newPreference.annonce_disabled;
            
            const badge = document.getElementById('annonceNotificationBadge');
            if (newPreference.annonce_disabled) {
                if (badge) badge.remove();
                annonceNotificationList.innerHTML = `
                    <div class="p-6 text-center text-gray-400">
                        <i class="fas fa-bell-slash text-2xl mb-2"></i>
                        <p class="text-sm">Notifications d'annonces désactivées</p>
                    </div>
                `;
            } else {
                loadAnnonceNotifications();
            }
            
            return true;
        }
        throw new Error(data.message || 'Erreur inconnue');
    });
}


    function formatExpirationMessage(message) {
        const hours = parseFloat(message.replace('Réservation se termine dans ', '').replace('h', ''));
        return Math.round(hours) + 'h';
    }

    function renderAnnonceNotifications(notifications) {
        if (notifications.length === 0) {
            annonceNotificationList.innerHTML = `
                <div class="p-6 text-center text-gray-400">
                    <i class="far fa-bell-slash text-2xl mb-2"></i>
                    <p class="text-sm">Aucune notification d'annonce</p>
                </div>
            `;
            return;
        }

        hasUnreadAnnonceNotifications = notifications.some(notif => !notif.read_at);

        annonceNotificationList.innerHTML = notifications.map(notif => `
            <div class="block p-3 hover:bg-gray-50 transition-colors duration-150 ${notif.read_at ? '' : 'bg-green-50'}">
                <div class="flex items-start">
                    <div class="flex-shrink-0 pt-0.5">
                        ${notif.data.type === 'annonce_modifiee' ? 
                            '<i class="fas fa-edit text-purple-500"></i>' : 
                            '<i class="fas fa-bullhorn text-green-500"></i>'}
                    </div>
                    <div class="ml-3 flex-1 min-w-0">
                        <p class="font-medium text-gray-800">
                            ${notif.data.type === 'annonce_modifiee' ? 'Annonce modifiée' : 'Nouvelle annonce'}
                        </p>
                        <p class="text-sm text-gray-600 mt-1">
                            ${notif.data.message || ''}
                        </p>
                        ${notif.data.titre ? `
                            <p class="text-xs text-gray-700 mt-1 bg-gray-100 p-1 rounded">
                                <strong>Titre:</strong> ${notif.data.titre}
                            </p>
                        ` : ''}
                        <p class="text-xs text-gray-500 mt-2 flex items-center">
                            <i class="far fa-clock mr-1"></i>
                            ${new Date(notif.created_at).toLocaleString('fr-FR', { 
                                day: 'numeric', 
                                month: 'short', 
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            })}
                        </p>
                        <a href="${notif.data.url || '#'}" class="mt-2 inline-block px-3 py-1 bg-blue-600 text-white text-xs rounded-full hover:bg-blue-700 transition-colors">
                            Détails
                        </a>
                    </div>
                </div>
            </div>
        `).join('');

        updateAnnonceBadgeUI();
    }

    function renderNotifications(notifications) {
        if (notifications.length === 0) {
            notificationList.innerHTML = `
                <div class="p-6 text-center text-gray-400">
                    <i class="far fa-bell-slash text-2xl mb-2"></i>
                    <p class="text-sm">Aucune notification disponible</p>
                </div>
            `;
            return;
        }

        hasUnreadOtherNotifications = notifications.some(notif => !notif.read_at);

        notificationList.innerHTML = notifications.map(notif => {
            const isReclamation = notif.data.type === 'reclamation_reponse';
            const isReservation = notif.data.type === 'reservation_expiration';
            
            if (isReclamation) {
                return `
                    <div class="block p-3 hover:bg-gray-50 transition-colors duration-150 ${notif.read_at ? '' : 'bg-blue-50'}">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 pt-0.5">
                                <i class="fas fa-reply text-blue-500"></i>
                            </div>
                            <div class="ml-3 flex-1 min-w-0">
                                <p class="font-medium text-gray-800">
                                    Réponse à votre réclamation
                                </p>
                                <p class="text-sm text-gray-600 mt-1">
                                    ${notif.data.message || ''}
                                </p>
                                <p class="text-xs text-gray-700 mt-1 bg-gray-100 p-1 rounded">
                                    <strong>Sujet:</strong> ${notif.data.sujet || ''}
                                </p>
                                <p class="text-xs text-gray-500 mt-2 flex items-center">
                                    <i class="far fa-clock mr-1"></i>
                                    ${new Date(notif.created_at).toLocaleString('fr-FR', { 
                                        day: 'numeric', 
                                        month: 'short', 
                                        year: 'numeric',
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    })}
                                </p>
                                <a href="{{ route('reclamations') }}" class="mt-2 inline-block px-3 py-1 bg-blue-600 text-white text-xs rounded-full hover:bg-blue-700 transition-colors">
                                    Détails
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            } else if (isReservation) {
                return `
                    <div class="block p-3 hover:bg-gray-50 transition-colors duration-150 ${notif.read_at ? '' : 'bg-blue-50'}">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 pt-0.5">
                                <i class="fas fa-clock text-orange-500"></i>
                            </div>
                            <div class="ml-3 flex-1 min-w-0">
                                <p class="font-medium text-gray-800">Réservation expirante</p>
                                <p class="text-sm text-gray-600 mt-1">
                                    Votre réservation #${notif.data.reservation_id || ''} expire bientôt
                                </p>
                                <p class="text-xs text-orange-600 mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    Expire dans: ${formatExpirationMessage(notif.data.message || '0h')}
                                </p>
                                <p class="text-xs text-gray-500 mt-2 flex items-center">
                                    <i class="far fa-clock mr-1"></i>
                                    ${new Date(notif.created_at).toLocaleString('fr-FR', { 
                                        day: 'numeric', 
                                        month: 'short', 
                                        year: 'numeric',
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    })}
                                </p>
                                <a href="${notif.data.url || '#'}" class="mt-2 inline-block px-3 py-1 bg-blue-600 text-white text-xs rounded-full hover:bg-blue-700 transition-colors">
                                    Détails
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                return `
                    <div class="block p-3 hover:bg-gray-50 transition-colors duration-150 ${notif.read_at ? '' : 'bg-blue-50'}">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 pt-0.5">
                                <i class="fas fa-bell text-gray-400"></i>
                            </div>
                            <div class="ml-3 flex-1 min-w-0">
                                <p class="font-medium text-gray-800">
                                    Notification
                                </p>
                                <p class="text-sm text-gray-600 mt-1">
                                    ${notif.data.message || ''}
                                </p>
                                <p class="text-xs text-gray-500 mt-2 flex items-center">
                                    <i class="far fa-clock mr-1"></i>
                                    ${new Date(notif.created_at).toLocaleString('fr-FR', { 
                                        day: 'numeric', 
                                        month: 'short', 
                                        year: 'numeric',
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    })}
                                </p>
                                <a href="${notif.data.url || '#'}" class="mt-2 inline-block px-3 py-1 bg-blue-600 text-white text-xs rounded-full hover:bg-blue-700 transition-colors">
                                    Détails
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            }
        }).join('');

        updateNotificationBadgeUI();
    }

function updateAnnonceBadgeUI() {
    if (notificationPreferences.annonceDisabled) {
        if (annonceNotificationBadge) {
            annonceNotificationBadge.remove();
            annonceNotificationBadge = null;
        }
        return;
    }

    if (hasUnreadAnnonceNotifications) {
        if (!annonceNotificationBadge) {
            annonceNotificationBadge = document.createElement('span');
            annonceNotificationBadge.id = 'annonceNotificationBadge';
            annonceNotificationBadge.className = 'absolute top-0 right-0 w-5 h-5 bg-green-500 text-white text-xs rounded-full flex items-center justify-center transform translate-x-1/2 -translate-y-1/2';
            annonceNotificationButton.appendChild(annonceNotificationBadge);
        }
        annonceNotificationBadge.classList.add('animate-ping-once');
        setTimeout(() => annonceNotificationBadge.classList.remove('animate-ping-once'), 1000);
    } else if (annonceNotificationBadge) {
        annonceNotificationBadge.remove();
        annonceNotificationBadge = null;
    }
}

    function updateNotificationBadgeUI() {
        if (hasUnreadOtherNotifications) {
            if (!notificationBadge) {
                notificationBadge = document.createElement('span');
                notificationBadge.id = 'notificationBadge';
                notificationBadge.className = 'absolute top-0 right-0 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center transform translate-x-1/2 -translate-y-1/2';
                notificationButton.appendChild(notificationBadge);
            }
            notificationBadge.classList.add('animate-ping-once');
            setTimeout(() => notificationBadge.classList.remove('animate-ping-once'), 1000);
        } else if (notificationBadge) {
            notificationBadge.remove();
            notificationBadge = null;
        }
    }

   function loadAnnonceNotifications() {
    if (notificationPreferences.annonceDisabled) {
        annonceNotificationList.innerHTML = `
            <div class="p-6 text-center text-gray-400">
                <i class="fas fa-bell-slash text-2xl mb-2"></i>
                <p class="text-sm">Notifications d'annonces désactivées</p>
            </div>
        `;
        return;
    }
    
    fetch('/client/notifications/latest?type=annonce')
        .then(response => response.json())
        .then(data => {
            renderAnnonceNotifications(data);
        });
}

document.addEventListener('DOMContentLoaded', function() {
    loadNotificationPreferences().then(() => {
        loadAnnonceNotifications();
        loadNotifications();
    });
    
    if (saveNotificationSettingsBtn) {
        saveNotificationSettingsBtn.addEventListener('click', function(e) {
            e.preventDefault();
            saveNotificationPreferences()
                .then(success => {
                    if (success) {
                        showToast('success', 'Préférences enregistrées');
                        notificationSettingsModal.classList.add('hidden');
                    }
                })
                .catch(error => {
                    showToast('error', error.message);
                });
        });
    }
});

    function loadNotifications() {
        fetch('/client/notifications/latest?type=other')
            .then(response => response.json())
            .then(data => {
                renderNotifications(data);
            });
    }

    function markAnnonceNotificationsAsRead() {
        hasUnreadAnnonceNotifications = false;
        updateAnnonceBadgeUI();
    }

    function markOtherNotificationsAsRead() {
        hasUnreadOtherNotifications = false;
        updateNotificationBadgeUI();
    }

    document.addEventListener('click', function(e) {
        if (!annonceNotificationDropdown.contains(e.target) && e.target !== annonceNotificationButton) {
            annonceNotificationDropdown.classList.add('hidden');
        }
        if (!notificationDropdown.contains(e.target) && e.target !== notificationButton) {
            notificationDropdown.classList.add('hidden');
        }
        if (!notificationSettingsModal.contains(e.target) && e.target !== notificationSettingsBtn) {
            notificationSettingsModal.classList.add('hidden');
        }
    });

    if (annonceNotificationButton) {
        annonceNotificationButton.addEventListener('click', function(e) {
            e.stopPropagation();
            annonceNotificationDropdown.classList.toggle('hidden');
            notificationDropdown.classList.add('hidden');
            if (!annonceNotificationDropdown.classList.contains('hidden')) {
                loadAnnonceNotifications();
            }
        });
    }

    if (notificationButton) {
        notificationButton.addEventListener('click', function(e) {
            e.stopPropagation();
            notificationDropdown.classList.toggle('hidden');
            annonceNotificationDropdown.classList.add('hidden');
            if (!notificationDropdown.classList.contains('hidden')) {
                loadNotifications();
            }
        });
    }

    if (markAnnonceAsRead) {
        markAnnonceAsRead.addEventListener('click', function(e) {
            e.preventDefault();
            fetch('/client/notifications/mark-as-read?type=annonce', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            }).then(() => {
                document.querySelectorAll('#annonceNotificationList .bg-green-50').forEach(el => {
                    el.classList.remove('bg-green-50');
                });
                markAnnonceNotificationsAsRead();
            });
        });
    }

    if (markAllAsRead) {
        markAllAsRead.addEventListener('click', function(e) {
            e.preventDefault();
            fetch('/client/notifications/mark-as-read?type=other', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            }).then(() => {
                document.querySelectorAll('#notificationList .bg-blue-50').forEach(el => {
                    el.classList.remove('bg-blue-50');
                });
                markOtherNotificationsAsRead();
            });
        });
    }

    if (notificationSettingsBtn) {
        notificationSettingsBtn.addEventListener('click', function() {
            notificationSettingsModal.classList.remove('hidden');
            loadNotificationPreferences();
        });
    }

    if (saveNotificationSettingsBtn) {
        saveNotificationSettingsBtn.addEventListener('click', function(e) {
            e.preventDefault();
            saveNotificationPreferences()
                .then(success => {
                    if (success) {
                        notificationSettingsModal.classList.add('hidden');
                    }
                })
                .catch(error => {
                    showToast('error', error.message);
                });
        });
    }

    loadNotificationPreferences().then(() => {
        loadAnnonceNotifications();
        loadNotifications();
    });
});


document.querySelectorAll('[x-data="{ show: true }"]').forEach(popup => {
    Alpine.initializeComponent(popup);
    popup._x_dataStack[0].show = false;
});

const successPopup = document.querySelector('[x-data="{ show: true }"]');
if (successPopup) {
    Alpine.initializeComponent(successPopup);
    successPopup._x_dataStack[0].show = false;
}

 const menuButton = document.getElementById('menuButton');
    const dropdownMenu = document.getElementById('dropdownMenu');

    menuButton.addEventListener('click', () => {
        dropdownMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', function(event) {
        if (!menuButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });
    </script>
</body>
</html>
