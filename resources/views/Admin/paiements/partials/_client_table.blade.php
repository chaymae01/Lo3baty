<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b bg-blue-50 flex justify-between items-center">
        <h3 class="text-lg font-medium text-blue-800">Paiements Clients</h3>
        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
            {{ $stats['count_clients'] }} paiements ({{ number_format($stats['total_clients'], 2) }} DH)
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Réservation</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($paiementsClients as $paiement)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#{{ $paiement->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <i data-lucide="user" class="w-5 h-5 text-blue-600"></i>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $paiement->client->surnom ?? $paiement->client->email }}</div>
                                <div class="text-sm text-gray-500">{{ $paiement->client->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">#{{ $paiement->reservation_id }}</div>
                        <div class="text-sm text-gray-500">
                            @if($paiement->reservation && $paiement->reservation->date_debut)
                                @if($paiement->reservation->date_debut instanceof \DateTime)
                                    {{ $paiement->reservation->date_debut->format('d/m/Y') }}
                                @else
                                    {{ \Carbon\Carbon::parse($paiement->reservation->date_debut)->format('d/m/Y') }}
                                @endif
                            @else
                                -
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                        {{ number_format($paiement->montant, 2) }} DH
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $paiement->etat === 'effectué' ? 'bg-green-100 text-green-800' : ($paiement->etat === 'annulé' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst($paiement->etat) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if($paiement->date_paiement)
                            @if($paiement->date_paiement instanceof \DateTime)
                                {{ $paiement->date_paiement->format('d/m/Y H:i') }}
                            @else
                                {{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y H:i') }}
                            @endif
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                        Aucun paiement client trouvé
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($paiementsClients->hasPages())
    <div class="px-6 py-3 bg-gray-50 border-t">
        {{ $paiementsClients->withQueryString()->links() }}
    </div>
    @endif
</div>