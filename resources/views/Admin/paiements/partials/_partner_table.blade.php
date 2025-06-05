<div class="bg-white rounded-lg shadow overflow-hidden mt-8">
    <div class="px-6 py-4 border-b bg-purple-50 flex justify-between items-center">
        <h3 class="text-lg font-medium text-purple-800">Paiements Partenaires</h3>
        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">
            {{ $stats['count_partenaires'] }} paiements ({{ number_format($stats['total_partenaires'], 2) }} DH)
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Partenaire</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Annonce</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Période</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($paiementsPartenaires as $paiement)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#{{ $paiement->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                <i data-lucide="user" class="w-5 h-5 text-purple-600"></i>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $paiement->partenaire->surnom }}</div>
                                <div class="text-sm text-gray-500">{{ $paiement->partenaire->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">Annonce #{{ $paiement->annonce_id }}</div>
                        <div class="text-sm text-gray-500">
                            {{ optional($paiement->annonce)->prix_journalier ?? '0' }} DH/jour
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                        {{ number_format($paiement->montant, 2) }} DH
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $paiement->periode }} jours
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $paiement->date_paiement->format('d/m/Y H:i') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                        Aucun paiement partenaire trouvé
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($paiementsPartenaires->hasPages())
    <div class="px-6 py-3 bg-gray-50 border-t">
        {{ $paiementsPartenaires->withQueryString()->links() }}
    </div>
    @endif
</div>