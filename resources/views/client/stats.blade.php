<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques Client</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-gradient-to-br from-black-50 to-black-200 min-h-screen">

@include('components.sideBar')

<div class="max-w-6xl mx-auto mt-16 px-4">
    <div class="mb-10">
        <h1 class="text-4xl font-bold text-black-800 mb-1">Statistiques de <span class="text-[#e63a28]">{{ $clientName }} {{ $clientPrenom }}</span></h1>
        <p class="text-sm text-black-500">Bienvenue sur votre tableau de bord personnalisé</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <!-- Stat Card -->
        @php
    $cards = [
        ['title' => 'Clients utilisant la plateforme', 'value' => $totalClients],
        ['title' => 'Nombre de Réservations', 'value' => $totalReservations],
        ['title' => 'Réclamations', 'value' => $totalReclamations],
        ['title' => 'Client depuis', 'value' => $startDate],
        ['title' => 'Note Moyenne', 'value' => $averageNote],
    ];
@endphp


        @foreach($cards as $card)
        <div class="bg-white p-6 rounded-xl  hover:shadow-xl transition duration-100 transform hover:scale-[1.01] backdrop-blur-md border border-black-300">
            <h2 class="text-black-600 text-sm font-medium mb-2 tracking-wide uppercase">{{ $card['title'] }}</h2>
            <p class="text-3xl font-bold text-[#e63a28]">{{ $card['value'] }}</p>
        </div>
        @endforeach
    </div>
</div>

</body>
</html>
