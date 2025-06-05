<div class="bg-white rounded-lg shadow p-6 mb-6">
    <form action="{{ route('admin.paiements') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Type de paiement -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
            <select name="type" id="filterType" class="w-full rounded-md border-gray-300 shadow-sm">
                <option value="">Tous les types</option>
                <option value="clients" {{ request('type') == 'clients' ? 'selected' : '' }}>Clients</option>
                <option value="partenaires" {{ request('type') == 'partenaires' ? 'selected' : '' }}>Partenaires</option>
            </select>
        </div>

        <!-- Méthode de paiement -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Méthode</label>
            <select name="methode" class="w-full rounded-md border-gray-300 shadow-sm">
                <option value="">Toutes méthodes</option>
                <option value="carte" {{ request('methode') == 'carte' ? 'selected' : '' }}>Carte bancaire</option>
                <option value="paypal" {{ request('methode') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                <option value="virement" {{ request('methode') == 'virement' ? 'selected' : '' }}>especes</option>
            </select>
        </div>

        <!-- Filtres Clients -->
        <div id="clientFilters" style="{{ request('type') != 'clients' ? 'display: none;' : '' }}">
            <label class="block text-sm font-medium text-gray-700 mb-1">Date début réservation</label>
            <input type="date" name="date_debut" value="{{ request('date_debut') }}" 
                   class="w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <div id="clientFilters2" style="{{ request('type') != 'clients' ? 'display: none;' : '' }}">
            <label class="block text-sm font-medium text-gray-700 mb-1">Date fin réservation</label>
            <input type="date" name="date_fin" value="{{ request('date_fin') }}" 
                   class="w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <!-- Filtres Partenaires -->
        <div id="partnerFilters" style="{{ request('type') != 'partenaires' ? 'display: none;' : '' }}">
            <label class="block text-sm font-medium text-gray-700 mb-1">Période Premium</label>
            <select name="periode_premium" class="w-full rounded-md border-gray-300 shadow-sm">
                <option value="">Toutes périodes</option>
                <option value="7" {{ request('periode_premium') == '7' ? 'selected' : '' }}>7 jours</option>
                <option value="15" {{ request('periode_premium') == '15' ? 'selected' : '' }}>15 jours</option>
                <option value="30" {{ request('periode_premium') == '30' ? 'selected' : '' }}>30 jours</option>
            </select>
        </div>

        <!-- Boutons -->
        <div class="md:col-span-4 flex justify-end space-x-3">
            <button type="submit" class="btn btn-primary">
                <i data-lucide="filter" class="w-4 h-4 mr-2"></i> Filtrer
            </button>
            <a href="{{ route('admin.paiements') }}" class="btn btn-secondary">
                <i data-lucide="x" class="w-4 h-4 mr-2"></i> Réinitialiser
            </a>
        </div>
    </form>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeFilter = document.getElementById('filterType');
    
    if (typeFilter) {
        typeFilter.addEventListener('change', function() {
            const type = this.value;
            
            // Gestion des filtres clients
            document.getElementById('clientFilters').style.display = type === 'clients' ? 'block' : 'none';
            document.getElementById('clientFilters2').style.display = type === 'clients' ? 'block' : 'none';
            
            // Gestion des filtres partenaires
            document.getElementById('partnerFilters').style.display = type === 'partenaires' ? 'block' : 'none';
        });
        
        // Déclenche l'événement change au chargement pour l'état initial
        typeFilter.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection