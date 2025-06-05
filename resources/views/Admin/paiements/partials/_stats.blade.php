<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <!-- Total Clients -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Clients</p>
                <p class="text-2xl font-bold text-blue-600">{{ number_format($stats['total_clients'], 2) }} DH</p>
            </div>
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
        </div>
        <p class="mt-2 text-xs text-gray-500">{{ $stats['count_clients'] }} transactions</p>
    </div>

    <!-- Total Partenaires -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Partenaires</p>
                <p class="text-2xl font-bold text-purple-600">{{ number_format($stats['total_partenaires'], 2) }} DH</p>
            </div>
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <i data-lucide="briefcase" class="w-6 h-6"></i>
            </div>
        </div>
        <p class="mt-2 text-xs text-gray-500">{{ $stats['count_partenaires'] }} transactions</p>
    </div>

    <!-- Dernier paiement client -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
        <div>
    <p class="text-sm font-medium text-gray-500">Dernier paiement client</p>
    <p class="text-lg font-semibold text-gray-900">
        @if($lastClient)
            {{ $lastClient->client->surnom ?? 'Inconnu' }} — {{ number_format($lastClient->montant, 2) }} DH
        @else
            N/A
        @endif
    </p>
</div>

            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i data-lucide="credit-card" class="w-6 h-6"></i>
            </div>
        </div>
        <p class="mt-2 text-xs text-gray-500">
            @if($lastClient)
                {{ $lastClient->date_paiement->diffForHumans() }}
            @endif
        </p>
    </div>

    <!-- Dernier paiement partenaire -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
        <div>
    <p class="text-sm font-medium text-gray-500">Dernier paiement partenaire</p>
    <p class="text-lg font-semibold text-gray-900">
        @if($lastPartner)
            {{ $lastPartner->partenaire->surnom ?? 'Inconnu' }} — {{ number_format($lastPartner->montant, 2) }} DH
        @else
            N/A
        @endif
    </p>
</div>

            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <i data-lucide="dollar-sign" class="w-6 h-6"></i>
            </div>
        </div>
        <p class="mt-2 text-xs text-gray-500">
            @if($lastPartner)
                {{ $lastPartner->date_paiement->diffForHumans() }}
            @endif
        </p>
    </div>
</div>