<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Évaluation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
         body{
                font-family: 'Sour Gummy', sans-serif;
        }
          /* body {
        font-family: 'Indie Flower', cursive;
    } */
        .rating-star {
            font-size: 1rem;
            cursor: pointer;
            color: #d1d5db;
            transition: all 0.2s ease;
        }
        .rating-star.active {
            color: #f59e0b;
        }
        .vintage-box {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            background-color: white;
        }
        .title-background {
            background-color: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 1.5rem;
        }
    </style>
</head>


<body class="bg-gray-50 text-gray-800">
        @include('components.sideBar')
    <div class="max-w-3xl mx-auto py-12 px-6">
        <h1 class="text-3xl font-bold text-center text-[#e63a28] mb-10">Évaluation de votre réservation</h1>

        <form action="{{ route('evaluations.store') }}" method="POST" class="space-y-8" x-data="{ submitted: false }" x-on:submit.prevent="fetch($event.target.action, {
            method: 'POST',
            body: new FormData($event.target)
        }).then(response => {
            if (response.ok) {
                submitted = true;
                setTimeout(() => window.location.href = '{{ route('annonces') }}', 1500);
            }
        })">
            @csrf
            <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
            <input type="hidden" name="objet_id" value="{{ $objet->id }}">
            <input type="hidden" name="partner_id" value="{{ $partner->id }}">
            <input type="hidden" name="client_id" value="{{ $reservation->client_id }}">

            <!-- Success Message (hidden by default) -->
            <div x-show="submitted" x-transition class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm mx-auto text-center">
                    <svg class="mx-auto h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">Évaluation soumise avec succès!</h3>
                    <p class="mt-1 text-sm text-gray-500">Vous serez redirigé vers l'accueil.</p>
                </div>
            </div>

            <!-- Box 1: Jouet -->
            <div class="vintage-box">
                <div class="title-background">
                    <h2 class="text-lg font-semibold text-gray-800">Évaluation du jouet</h2>
                </div>
                <div class="p-6 space-y-4">
                    <p class="text-base font-medium text-gray-700">{{ $objet->nom }}</p>

                    <div class="space-y-3">
                        <div class="flex items-center gap-4">
                            <span class="text-sm font-medium text-gray-600 whitespace-nowrap">Votre note:</span>
                            <div x-data="{ rating: 0 }" class="flex items-center gap-1">
                                <template x-for="i in 5">
                                    <button type="button" @click="rating = i" class="rating-star"
                                            :class="{ 'active': i <= rating }">★</button>
                                </template>
                                <input type="hidden" name="annonce_note" x-model="rating" required>
                            </div>
                        </div>

                        <label class="block space-y-1">
                            <span class="text-sm font-medium text-gray-600">Commentaire sur le jouet</span>
                            <textarea name="annonce_comment" rows="3" placeholder="Décrivez votre expérience avec ce jouet..."
                                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-2 focus:ring-purple-200 focus:border-purple-400"></textarea>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Box 2: Partenaire -->
            <div class="vintage-box">
                <div class="title-background">
                    <h2 class="text-lg font-semibold text-gray-800">Évaluation du partenaire</h2>
                </div>
                <div class="p-6 space-y-4">
                    <p class="text-base font-medium text-gray-700">{{ $partner->nom }}</p>

                    <div class="space-y-3">
                        <div class="flex items-center gap-4">
                            <span class="text-sm font-medium text-gray-600 whitespace-nowrap">Votre note:</span>
                            <div x-data="{ rating: 0 }" class="flex items-center gap-1">
                                <template x-for="i in 5">
                                    <button type="button" @click="rating = i" class="rating-star"
                                            :class="{ 'active': i <= rating }">★</button>
                                </template>
                                <input type="hidden" name="partner_note" x-model="rating" required>
                            </div>
                        </div>

                        <label class="block space-y-1">
                            <span class="text-sm font-medium text-gray-600">Commentaire sur le partenaire</span>
                            <textarea name="partner_comment" rows="3" placeholder="Décrivez votre expérience avec ce partenaire..."
                                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-2 focus:ring-purple-200 focus:border-purple-400"></textarea>
                        </label>
                    </div>
                </div>
            </div>

            <div class="text-center pt-4">
                <button type="submit"
                        class="bg-red-600 text-white px-6 py-2.5 rounded-md hover:bg-red-700 transition font-medium">
                    Soumettre les évaluations
                </button>
            </div>
        </form>
    </div>
</body>
</html>