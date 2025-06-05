<!DOCTYPE html>
<html lang="fr">
<head>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Réservations</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* body {
        font-family: 'Nunito', sans-serif;
    }*/
        .statut-badge { 
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
        }
        
        button:disabled:hover {
    background-color:rgb(235, 80, 37) !important; /* bg-blue-600 */
}
        .statut-en_attente { background-color: #fef3c7; color: #d97706; }
        .statut-confirmée { background-color: #d1fae5; color:rgb(13, 122, 88); }
        .statut-refusée { background-color: #f3f4f6; color:rgb(215, 64, 51); }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-white-100" x-data="{ 
    activeStatus: 'all',
    selectedReservation: null,
    getStatusColor(status) {
        return {
            'en_attente': 'statut-en_attente',
            'confirmée': 'statut-confirmée',
            'refusée': 'statut-refusée'
        }[status] || 'bg-gray-100';
    }}" x-cloak>
    
    @include('components.sideBar')

    <!-- Sidebar -->
    <div class="fixed left-0 top-15 h-full w-64 bg-white p-4 z-10">
        <h2 class="text-lg font-bold mb-3"> Filtrer par statut</h2>
        <nav class="space-y-2">
            <template x-for="status in ['all', 'en_attente', 'confirmée', 'refusée']" :key="status">
                <button 
                    @click="activeStatus = status"
                    :class="activeStatus === status ? 
                        {'bg-purple-100 text-purple-700': status === 'all',
                         'bg-yellow-100 text-yellow-700': status === 'en_attente',
                         'bg-green-100 text-green-700': status === 'confirmée',
                         'bg-red-100 text-red-700': status === 'refusée'} : 
                        'text-gray-600 hover:bg-gray-200'"
                    class="w-full text-left px-4 py-2 rounded-lg transition-colors">
                    <span x-text="{
                        all: 'Toutes les réservations',
                        en_attente: 'En attente',
                        confirmée: 'Confirmée',
                        refusée: 'Refusée'
                    }[status]"></span>
                </button>
            </template>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="ml-64 p-8">
        <h1 class="text-3xl font-bold mb-8">Mes Réservations</h1>

        <div class="space-y-6">
            @forelse($reservations as $reservation)
                @php
                    // Dates
                    $dateDebut = $reservation->date_debut ? Carbon\Carbon::parse($reservation->date_debut) : null;
                    $dateFin = $reservation->date_fin ? Carbon\Carbon::parse($reservation->date_fin) : null;
                    $duree = $dateDebut && $dateFin ? abs(($dateDebut->diffInDays($dateFin))+1) : 0;
                    
                    // Relations
                    $annonce = $reservation->annonce ?? null;
                    $objet = $annonce->objet ?? null;
                    $image = $objet?->images->first() ?? null;
                    
                    // Calculs financiers
                    $prixJournalier = $annonce->prix_journalier ?? 0;
                    $prixTotal = abs($prixJournalier * $duree);

                    // Info partenaire
                    $partenaire = $annonce?->proprietaire;
                    $estPartenaire = $partenaire && strtolower(trim($partenaire->role)) === 'partenaire';                    
                    $notePartenaire = $estPartenaire 
                        ? ($partenaire->evaluationsPartenaire->avg('note') ?? 0)
                        : 0;
                @endphp

                <div 
                    class="bg-blue rounded-xl border border-gray-300 shadow-sm hover:shadow-md p-4 cursor-pointer group relative"
                    x-show="activeStatus === 'all' || activeStatus === '{{ $reservation->statut }}'"
                    @click="selectedReservation = {
                        id: @js($reservation->id),
                        objet: @js($objet?->nom ?? 'N/A'),
                        image: @js($image?->url ? asset($image->url) : null),
                        dateDebut: @js($dateDebut?->translatedFormat('d M Y') ?? 'N/A'),
                        dateFin: @js($dateFin?->format('Y-m-d')),
                        duree: @js($duree),
                        prixJournalier: @js(number_format(abs($prixJournalier), 0, ',', ' ') . ' DH'),
                        prixTotal: @js(number_format($prixTotal, 0, ',', ' ') . ' DH'),
                        annonceId: @js($annonce?->id ?? 'N/A'),
                        statut: @js($reservation->statut),
                        evaluationDate: @js($reservation->evaluation_date ? Carbon\Carbon::parse($reservation->evaluation_date)->translatedFormat('d M Y') : 'Non évalué'),
                        emailStatus: @js($reservation->is_email ? 'Email devaluation reçu (Voir boite mail!)' : 'Email devaluation non reçu'),
                        details: @js($objet?->description ?? 'Aucune description disponible'),
                        partenaire: {  
                            estPartenaire: @js($estPartenaire), 
                        nom: @js($estPartenaire ? ($partenaire->nom ?? 'N/A') : 'N/A'),
                        email: @js($estPartenaire ? ($partenaire->email ?? 'N/A') : 'N/A'),
                        note: @js($estPartenaire ? number_format($notePartenaire, 1) : 'N/A')
                        }
                    }"
                >
                    <div class="flex justify-between items-start">
                        <div class="">
                            <div class="flex items-start gap-9">
                                @if($image)
                                <img src="{{ asset('storage/' . $image->url) }}"
                                     class="w-24 h-24 object-cover rounded-lg" 
                                     alt="Image du jouet">
                                @endif
                                <div class="flex-1">
                                <h2 class=" text-xl font-bold text-black">
                                        {{ $objet->nom ?? 'Annonce #'.$reservation->annonce_id }}
                                    </h2>
                                    <div class="text-sm text-black-600 mt-2">
                                        @if($dateDebut && $dateFin)
                                            {{ $dateDebut->translatedFormat('d M Y') }} - 
                                            {{ $dateFin->translatedFormat('d M Y') }}
                                            <br>
                                    <div class="mt-2 text-xs ">
                                            {{ $duree }} jours
                                        @else
                                            Dates non spécifiées
                                        @endif
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col items-end gap-4 mt-2 mr-4">
                            <span class="text-3xl font-bold text-black-100">
                                {{ number_format($prixTotal, 0, ',', ' ') }} DH
                            </span>
                            <span class="statut-badge {{ [
                                'en_attente' => 'statut-en_attente',
                                'confirmée' => 'statut-confirmée',
                                'refusée' => 'statut-refusée'
                            ][$reservation->statut] ?? 'bg-gray-100' }}">
                                {{ isset($reservation->statut) ? ucfirst(str_replace('_', ' ', $reservation->statut)) : 'Statut inconnu' }}
                            </span>
                        </div>
                    </div>

                    <!-- <div class="mt-4 pt-4 border-t border-black-100">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">
                                @if($reservation->evaluation_date)
                                    Évalué le {{ Carbon\Carbon::parse($reservation->evaluation_date)->translatedFormat('d M Y') }}
                                @else
                                    Non évalué
                                @endif
                            </span>
                        </div>
                    </div> -->
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white rounded-lg">
                    <p class="text-black-500">Aucune réservation trouvée</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal Détails -->
    <div x-show="selectedReservation !== null" 
         class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4"
         @click.away="selectedReservation = null">
        <div class="bg-white rounded-xl max-w-2xl w-full p-8">
            <div class="flex justify-between items-start mb-2"> <!-- Changed mb-6 to mb-2 -->
                <div>
                    <h3 class="text-2xl font-bold mb-1" x-text="selectedReservation.objet"></h3>
                    <div class="flex text-sm mt-1">
                        <span class="text-gray-500">ID Annonce:</span>
                        <span class="font-mono text-gray-700 ml-1 mb-3" x-text="selectedReservation.annonceId"></span>
                    </div>
                </div>

                <button @click="selectedReservation = null" class="text-gray-500 hover:text-gray-700">
                ✕
                </button>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-2">Période de location</p>
                        <p class="font-semibold" x-text="`${selectedReservation.dateDebut} - ${selectedReservation.dateFin}`"></p>
                        <p class="text-sm text-black-600" x-text="`(${selectedReservation.duree} jours)`"></p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500 mb-2">Détails financiers</p>
                        <div class="">
                            <div class="flex justify-between ">
                                <span>Prix journalier:</span>
                                <span class="font-bold" x-text="selectedReservation.prixJournalier"></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Total (à) payé(r):</span>
                                <span class="text-green-600 font-bold" x-text="selectedReservation.prixTotal"></span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-2 space-y-1">
                    <p class="text-sm text-gray-500 mb-2">Détails de Partenaire</p>
                        <template x-if="selectedReservation.partenaire && selectedReservation.partenaire.nom !== 'N/A'">
                            <div>
                                <p class="font-medium" x-text="'Nom: ' + selectedReservation.partenaire.nom"></p>
                                <p x-text="'Email: ' + selectedReservation.partenaire.email"></p>
                                <p x-text="'Note moyenne:  ' + (selectedReservation.partenaire.note || '0') + '/ 5'"></p>
                            </div>
                        </template>
                        <template x-if="!selectedReservation.partenaire || selectedReservation.partenaire.nom === 'N/A'">
                            <p class="text-black-500">Information partenaire non disponible</p>
                        </template>
                    </div>
                </div>

                <div class="space-y-4">

                    <div>
                        <p class="text-sm text-gray-500 mb-2">État de la réservation</p>
                        <span class="statut-badge" 
                              :class="getStatusColor(selectedReservation.statut)"
                              x-text="selectedReservation.statut ? selectedReservation.statut.replace('_', ' ') : 'N/A'"></span>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 mt-0">Description</p>
                        <p class="text-black-600" x-text="selectedReservation.details"></p>
                    </div>
                </div>
            </div>

          <div class="mt-8 pt-1 border-t border-black-100">
    <div class="flex justify-between items-center text-sm text-gray-600 mt-3 mb-0">
        <div class="flex space-x-4 " >
            <span x-text="selectedReservation.emailStatus"></span>
            <span x-text="`Évaluation: ${selectedReservation.evaluationDate}`" ></span>
        </div>
        
        <!-- Updated Evaluation Button -->
        <div x-data="{
            isEvaluable() {
                if (!selectedReservation?.dateFin) return false;
                const today = new Date().toISOString().split('T')[0];
                return selectedReservation.dateFin <= today;
            }
        }">
            <template x-if="isEvaluable() && selectedReservation.id">
                <a :href="`/evaluation_annonce/${selectedReservation.id}`"
                   class="px-4 py-2 text-sm font-medium text-white bg-[#e63a28] rounded-lg hover:bg-[#e63a20] transition-colors flex items-center">
                    Évaluer
                </a>
            </template>
            
            <template x-if="!isEvaluable()">
                <div class="text-sm text-gray-500 italic">
                    Evaluation après <span x-text="new Date(selectedReservation.dateFin).toLocaleDateString('fr-FR', { day: 'numeric', month: 'short', year: 'numeric' })"></span>
                </div>
            </template>
        </div>
    </div>
</div>
        </div>
    </div>
</body>
</html>