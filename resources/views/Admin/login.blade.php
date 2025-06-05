<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 animate-fade-in">
        <div class="flex justify-center mb-6">
            <div class="bg-blue-100 p-3 rounded-full">
                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 11c0 .656-.316 1.25-.828 1.625a2.002 2.002 0 01-2.344 0C8.316 12.25 8 11.656 8 11V7a4 4 0 118 0v4z"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5.121 17.804A6.978 6.978 0 0012 20a6.978 6.978 0 006.879-2.196M12 14a7.5 7.5 0 00-6.879 3.804"/>
                </svg>
            </div>
        </div>

        <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Connexion Administrateur</h2>
        <p class="text-center text-sm text-gray-500 mb-6">Entrez vos identifiants pour accéder au tableau de bord</p>

        <form method="POST" action="{{ route('admin.login') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm text-gray-700 mb-1" for="email">Email</label>
                <input type="email" name="email" id="email" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150 ease-in-out">
            </div>

            <div>
                <label class="block text-sm text-gray-700 mb-1" for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-150 ease-in-out">
            </div>

            @if ($errors->any())
                <div class="text-red-600 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <button type="submit"
                    class="w-full bg-blue-500 text-white font-semibold py-2 rounded-lg hover:bg-blue-600 transition duration-200 shadow-md">
                Se connecter
            </button>
        </form>
    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }
    </style>

</body>
</html>
