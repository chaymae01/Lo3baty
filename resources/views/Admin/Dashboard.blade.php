@extends('admin.layouts.app')

@section('title', 'Tableau de Bord')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar fixe à gauche -->
    <div class="w-64 fixed top-0 left-0 bottom-0 bg-white shadow-md z-10">
        @include('admin.layouts.sidebar')
    </div>

    <!-- Contenu principal avec marge pour la sidebar -->
    <div class="flex-1 p-8 space-y-10 ml-64">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Tableau de Bord</h1>
        </div>

        <!-- Statistiques Rapides -->
       <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Partenaires -->
    <div class="bg-gradient-to-br from-blue-100 to-blue-90 p-6 rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <h2 class="text-blue-800 text-sm uppercase font-semibold">Partenaires</h2>
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M17 20h5v-2a3 3 0 0 0-5.356-1.857M9 20H4v-2a3 3 0 0 1 5.356-1.857M15 11a3 3 0 1 0-6 0M21 21H3"></path>
            </svg>
        </div>
        <p class="mt-4 text-3xl font-bold text-blue-900">{{ $partnerCount }}</p>
    </div>

    <!-- Clients -->
    <div class="bg-gradient-to-br from-purple-100 to-purple-90 p-6 rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <h2 class="text-purple-800 text-sm uppercase font-semibold">Clients</h2>
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M17 20h5v-2a3 3 0 0 0-5.356-1.857M9 20H4v-2a3 3 0 0 1 5.356-1.857M15 11a3 3 0 1 0-6 0M21 21H3"></path>
            </svg>
        </div>
        <p class="mt-4 text-3xl font-bold text-purple-900">{{ $clientCount }}</p>
    </div>

    <!-- Annonces -->
    <div class="bg-gradient-to-br from-yellow-100 to-yellow-90 p-6 rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <h2 class="text-yellow-800 text-sm uppercase font-semibold">Annonces</h2>
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 5h18M9 3v2m6-2v2M3 10h18M5 21h14a2 2 0 0 0 2-2V7H3v12a2 2 0 0 0 2 2z"></path>
            </svg>
        </div>
        <p class="mt-4 text-3xl font-bold text-yellow-900">{{ $annonceCount }}</p>
    </div>
<div class="bg-gradient-to-br from-red-100 to-red-50 p-6 rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
    <div class="flex items-center justify-between">
        <h2 class="text-red-800 text-sm uppercase font-semibold">Réclamations Nouvelles</h2>
        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2zM3 5v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5H3z"></path>
        </svg>
    </div>
    <p class="mt-4 text-3xl font-bold text-red-900">{{ $nouveauxReclamations }}</p>
</div>


</div>
<!-- Revenus et Revenus par période avec flèches -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- Carte : Revenus -->
    <div class="relative bg-gradient-to-br from-green-100 to-green-50 p-6 pr-24 rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1 overflow-hidden">
        <!-- Flèche à droite -->
        <div class="absolute right-0 top-1/2 -translate-y-1/2">
            <div class="w-0 h-0 border-t-[40px] border-t-transparent border-b-[40px] border-b-transparent border-l-[60px] border-l-green-300"></div>
        </div>

        <!-- Contenu -->
        <div class="relative z-10">
            <div class="flex items-center justify-between">
                <h2 class="text-green-800 text-sm uppercase font-semibold">Revenus</h2>
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8c-1.104 0-2 .672-2 1.5S10.896 11 12 11s2 .672 2 1.5S13.104 14 12 14m0-6v1m0 7v1m9-7a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"></path>
                </svg>
            </div>
            <p class="mt-4 text-3xl font-bold text-green-900">{{ $totalRevenue }} MAD</p>
        </div>
    </div>

    <!-- Carte : Revenus par période -->
    <div class="relative bg-gradient-to-br from-green-100 to-green-50 p-6 pr-24 rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-1 overflow-hidden">
        <!-- Flèche à droite -->
        <div class="absolute right-0 top-1/2 -translate-y-1/2">
            <div class="w-0 h-0 border-t-[40px] border-t-transparent border-b-[40px] border-b-transparent border-l-[60px] border-l-green-300"></div>
        </div>

        <!-- Contenu -->
        <div class="relative z-10">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Total des revenus premium par Période</h3>
            <ul class="divide-y divide-gray-200">
                @forelse($revenusParPeriode as $revenu)
                    <li class="py-2 flex justify-between items-center">
                        <span class="text-gray-800 font-medium">{{ $revenu->periode }} jours</span>
                        <span class="text-green-600 font-bold">{{ number_format($revenu->total, 2) }} MAD</span>
                    </li>
                @empty
                    <li class="py-2 text-gray-500">Aucun paiement enregistré</li>
                @endforelse
            </ul>
        </div>
    </div>

</div>


        <!-- Sections Détaillées -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- Performance du logement -->
           <!-- Performance du logement -->
<div class="bg-white p-6 rounded-2xl shadow-lg">
    <h3 class="text-lg font-semibold mb-4 text-gray-700"> Revenus du logement</h3>
    <canvas id="logementPerformanceChart" class="w-full h-64"></canvas>
</div>

  <!-- Revenus locatifs -->
            <div class="bg-white p-6 rounded-2xl shadow-lg">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Revenus du premium</h3>
              <canvas id="revenusChart" class="w-full h-64"></canvas>

            </div>
            <!-- Calendrier locatif -->
           <!-- Calendrier locatif -->



          

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    
    <!-- Nouvelles Annonces de Locations -->
    <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">
        <div class="flex items-center mb-6">
            <svg class="w-6 h-6 text-indigo-500 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M3 10l1.45 1.39a2 2 0 002.83 0L12 6.66l4.71 4.73a2 2 0 002.83 0L21 10M5 21h14a2 2 0 002-2v-7H3v7a2 2 0 002 2z"/>
            </svg>
            <h3 class="text-xl font-bold text-gray-900">Nouvelles Annonces de Locations</h3>
        </div>
        <ul class="space-y-4">
            @forelse($latestAnnonces as $annonce)
                <li class="bg-gray-50 p-4 rounded-xl hover:bg-gray-100 transition">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-semibold text-gray-800">
                            {{ $annonce->partenaire->nom }} {{ $annonce->partenaire->prenom }}
                        </span>
                        <span class="text-xs bg-indigo-100 text-indigo-600 px-2 py-1 rounded-full">
                            ID {{ $annonce->id }}
                        </span>
                    </div>
                    <div class="text-sm text-gray-600 flex justify-between">
                        <span>{{ $annonce->objet->ville }} — {{ $annonce->objet->prix_journalier }} MAD</span>
                        <span class="text-xs text-gray-400">
                            {{ $annonce->date_publication->format('d/m/Y') }}
                        </span>
                    </div>
                </li>
            @empty
                <li class="text-gray-500 text-sm">Aucune annonce récente</li>
            @endforelse
        </ul>
        <div class="text-xs text-gray-400 mt-4">
            @if($latestAnnonces->count() > 0)
                Résultats 1 à {{ $latestAnnonces->count() }} sur {{ $annonceCount }}
            @else
                Aucun résultat
            @endif
        </div>
    </div>

    <!-- Réclamations Récentes -->
    <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">
        <div class="flex items-center mb-6">
            <svg class="w-6 h-6 text-red-500 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M18.364 5.636a9 9 0 11-12.728 0M12 3v9" />
            </svg>
            <h3 class="text-xl font-bold text-gray-900">Réclamations Récentes</h3>
        </div>
        <ul class="space-y-4">
            @forelse($reclamations as $reclamation)
                <li class="bg-gray-50 p-4 rounded-xl hover:bg-gray-100 transition">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-semibold text-gray-800">
                            {{ $reclamation->utilisateur->nom ?? 'Nom inconnu' }} 
                            {{ $reclamation->utilisateur->prenom ?? 'Prénom inconnu' }}
                        </span>
                        <span class="text-xs px-2 py-1 rounded-full
                            @if($reclamation->statut == 'en_attente') bg-yellow-100 text-yellow-800
                            @elseif($reclamation->statut == 'en_cours') bg-blue-100 text-blue-800
                            @else bg-green-100 text-green-800
                            @endif">
                            {{ ucfirst($reclamation->statut) }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600">
                        {{ $reclamation->message ?? 'Aucune description fournie' }}
                    </p>
                </li>
            @empty
                <li class="text-gray-500 text-sm">Aucune réclamation récente</li>
            @endforelse
        </ul>
        <div class="text-xs text-gray-400 mt-4">
            @if($reclamations->count() > 0)
                Résultats 1 à {{ $reclamations->count() }} sur {{ $reclamations->count() }}
            @else
                Aucun résultat
            @endif
        </div>
    </div>

</div>


<div class="bg-white p-6 rounded-2xl shadow-lg">
    <h3 class="text-lg font-semibold mb-4 text-gray-700">Calendrier locatif</h3>
    <div id="calendar"></div> <!-- Utilise un vrai conteneur -->
</div>
            <!-- Nouveaux partenaires -->
            <div class="bg-white p-6 rounded-2xl shadow-lg">
    <h3 class="text-xl font-semibold text-gray-800 mb-6 border-b border-gray-300 pb-2">Nouveaux Partenaires</h3>
    <ul class="space-y-4">
        @foreach($newPartners as $partner)
            <li class="p-4 border rounded-lg shadow-sm hover:shadow-md transition duration-300 ease-in-out">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-lg font-medium text-gray-900">
                        {{ $partner->nom }} {{ $partner->prenom }}
                    </span>
                    <span class="text-sm text-gray-500">
                        {{ $partner->annonces_count }} annonces actives
                    </span>
                </div>
                <div class="text-xs text-gray-500">
                   
                </div>
            </li>
        @endforeach
    </ul>
    <a href="{{ route('admin.partenaires') }}" class="block mt-6 text-sm text-blue-600 hover:underline">
        Voir plus de partenaires
    </a>
</div>

            

            <!-- Commentaires -->
           <div class="bg-white p-6 rounded-2xl shadow-lg">
    <h3 class="text-xl font-semibold text-gray-800 mb-6 border-b border-gray-300 pb-2">Commentaires</h3>
    <ul class="space-y-4">
        @foreach($evaluations as $evaluation)
            <li class="p-4 border rounded-xl shadow-sm hover:shadow-md transition duration-300 ease-in-out">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-lg font-medium text-gray-900">
                        @if($evaluation->objet && $evaluation->client)
                            <span class="text-indigo-600">{{ $evaluation->objet->nom ?? 'Objet inconnu' }}</span> - 
                            <span class="text-indigo-600">{{ $evaluation->client->nom ?? 'Client inconnu' }}</span>:
                        @else
                            <span class="text-red-600 font-bold">Évaluation incomplète (ID: {{ $evaluation->id }})</span>
                        @endif
                    </span>
                </div>
                <p class="text-gray-700 text-sm mb-2">
                    {{ $evaluation->commentaire ?? 'Aucun commentaire fourni.' }}
                </p>
                <div class="flex justify-between text-xs text-gray-500">
                    @if($evaluation->date)
                        <span>Publié le : {{ $evaluation->date->format('d/m/Y') }}</span>
                    @endif
                    <span class="text-gray-600">Note: 
                        <span class="font-semibold text-yellow-500">{{ $evaluation->note ?? 'N/A' }}</span>
                    </span>
                </div>
            </li>
        @endforeach
    </ul>
    <a href="{{ route('admin.commentaires') }}" class="block mt-6 text-sm text-blue-600 hover:underline">
        Voir plus de commentaires
    </a>
</div>


        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const labels = {!! json_encode($revenusParPeriode->pluck('periode')) !!};
        const data = {!! json_encode($revenusParPeriode->pluck('total')) !!};

        const ctx = document.getElementById('revenusChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels.map(p => p + " jours"),
                datasets: [{
                    label: 'Revenus en MAD',
                    data: data,
                    backgroundColor: 'rgba(197, 184, 34, 0.6)',
                    borderColor: 'rgb(34, 126, 197)',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: context =>
                                context.parsed.y.toLocaleString('fr-FR', {
                                    style: 'currency',
                                    currency: 'MAD'
                                })
                        }
                    },
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value =>
                                value.toLocaleString('fr-FR') + ' MAD'
                        }
                    }
                }
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const logementLabels = {!! json_encode($revenusParLogement->pluck('Ville')) !!};
        const logementData = {!! json_encode($revenusParLogement->pluck('total')) !!};

        const ctx = document.getElementById('logementPerformanceChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: logementLabels,
                datasets: [{
                    label: 'Revenus par logement (MAD)',
                    data: logementData,
                    backgroundColor: 'rgba(75, 98, 192, 0.6)',
                    borderColor: 'rgb(149, 75, 192)',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: context =>
                                context.parsed.y.toLocaleString('fr-FR', {
                                    style: 'currency',
                                    currency: 'MAD'
                                })
                        }
                    },
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value =>
                                value.toLocaleString('fr-FR') + ' MAD'
                        }
                    },
                    x: {
                        ticks: {
                            callback: function(value, index, values) {
                                let label = this.getLabelForValue(value);
                                return label.length > 20 ? label.slice(0, 20) + '…' : label;
                            }
                        }
                    }
                }
            }
        });
    });
</script>




<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 500,
            events: @json($reservations),
            eventColor: '#1d4ed8',
            eventDisplay: 'block',
            eventContent: function(arg) {
                return {
                    html: `<div class="fc-event-title">${arg.event.title}</div>`
                };
            },
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            }
        });
        calendar.render();
    });
</script>

@endsection
