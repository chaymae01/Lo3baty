<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Partner Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="navbar bg-white border-b border-gray-200 px-4 py-3 flex justify-between items-center shadow-sm">
        <!-- Mobile menu toggle -->
        <button class="sm:hidden text-gray-600" aria-label="Toggle menu" onclick="document.getElementById('sidebar').classList.toggle('hidden')">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <div class="text-xl font-semibold text-gray-700">Partenaire</div>

        <!-- Right buttons -->
        <div class="flex items-center gap-4">
            <!-- Notification -->
            <button class="relative text-gray-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-5-5.917V5a2 2 0 10-4 0v.083A6 6 0 004 11v3.159c0 .538-.214 1.055-.595 1.436L2 17h5m3 0v1a3 3 0 006 0v-1m-6 0h6"/>
                </svg>
                <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
            </button>

            <!-- Avatar -->
            <div class="relative">
                <img class="h-9 w-9 rounded-full" src="https://cdn.flyonui.com/fy-assets/avatar/avatar-1.png" alt="avatar">
            </div>
        </div>
    </nav>

    <!-- Sidebar + Main -->
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="bg-white shadow-md w-64 px-4 pt-6 space-y-2 sm:block hidden">
            <nav class="flex flex-col space-y-1">
                <a href="{{ route('partner.dashboard') }}"
                   class="flex items-center px-3 py-2 rounded hover:bg-gray-100 text-gray-700">
                    <span class="icon-[tabler--home] mr-2"></span>
                    Dashboard
                </a>
                <a href="{{ route('partner.products.index') }}"
                   class="flex items-center px-3 py-2 rounded hover:bg-gray-100 text-gray-700">
                    <span class="icon-[tabler--shopping-bag] mr-2"></span>
                    Produits
                </a>
            </nav>
        </aside>

        <!-- Main content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>
</body>
</html>
