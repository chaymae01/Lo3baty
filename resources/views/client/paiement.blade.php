@extends('layouts.app')
@include('components.sideBar')
@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Finaliser votre réservation</h2>
            
            <!-- Récapitulatif -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Récapitulatif</h3>
                
                <div class="flex items-center mb-4">
                    <img src="{{ asset('storage/' . $reservation->annonce->objet->images->first()->url) }}" 
                            alt="{{ $reservation->annonce->objet->nom }}"
                         class="w-20 h-20 object-cover rounded-lg mr-4">
                    <div>
                        <h4 class="font-medium">{{ $reservation->annonce->objet->nom }}</h4>
                        <p class="text-sm text-gray-600">
                            {{ $reservation->date_debut->format('d/m/Y') }} - 
                            {{ $reservation->date_fin->format('d/m/Y') }}
                            ({{ $reservation->date_debut->diffInDays($reservation->date_fin) + 1 }} jours)
                        </p>
                    </div>
                </div>
                
                <div class="border-t pt-4">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Prix journalier:</span>
                        <span>{{ number_format($reservation->annonce->prix_journalier, 2) }} MAD</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Durée:</span>
                        <span>{{ $reservation->date_debut->diffInDays($reservation->date_fin) + 1 }} jours</span>
                    </div>
                    <div class="border-t my-2"></div>
                    <div class="flex justify-between font-bold text-lg">
                        <span>Total:</span>
                        <span id="totalWithoutDelivery">{{ number_format($reservation->annonce->prix_journalier * ($reservation->date_debut->diffInDays($reservation->date_fin) + 1), 2) }} MAD</span>
                    </div>
                </div>
            </div>
            
            <!-- Formulaire de paiement -->
            <form action="{{ route('paiement.process') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Méthode de paiement</h3>
                    
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <input type="radio" id="paypal" name="methode" value="paypal" class="hidden peer" checked>
                            <label for="paypal" class="flex flex-col items-center justify-center p-4 border rounded-lg cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50">
                                <i class="fab fa-paypal text-3xl text-blue-500 mb-2"></i>
                                <span>PayPal</span>
                            </label>
                        </div>
                        <div>
                            <input type="radio" id="especes" name="methode" value="especes" class="hidden peer">
                            <label for="especes" class="flex flex-col items-center justify-center p-4 border rounded-lg cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50">
                                <i class="fas fa-money-bill-wave text-3xl text-green-500 mb-2"></i>
                                <span>Espèces</span>
                            </label>
                        </div>
                        <div>
                            <input type="radio" id="carte" name="methode" value="carte" class="hidden peer">
                            <label for="carte" class="flex flex-col items-center justify-center p-4 border rounded-lg cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50">
                                <i class="fas fa-money-check-alt text-3xl text-purple-500 mb-2"></i>
                                <span>Carte bancaire</span>
                            </label>
                        </div>
                    </div>
                </div>
                
<!-- Option de livraison -->
<div class="mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Options de livraison</h3>
    
    <div class="flex items-center mb-4">
        <input type="radio" id="sans_livraison" name="livraison" value="0" class="mr-2" checked>
        <label for="sans_livraison" class="flex-grow">
            <span class="font-medium">Sans livraison</span>
            <p class="text-sm text-gray-600">Vous récupérerez l'objet chez le partenaire</p>
        </label>
    </div>
    
    <div class="flex items-center">
        <input type="radio" id="avec_livraison" name="livraison" value="1" class="mr-2">
        <label for="avec_livraison" class="flex-grow">
            <span class="font-medium">Avec livraison</span>
            <p class="text-sm text-gray-600">Livraison à votre domicile (+20 DH)</p>
        </label>
        <span id="deliveryCost" class="text-gray-600">+20.00 MAD</span>
    </div>
</div>
                
                <!-- Total final -->
                <div class="bg-blue-50 p-4 rounded-lg mb-6">
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-lg">Total à payer:</span>
                        <span id="finalTotal" class="font-bold text-xl text-blue-600">
                            {{ number_format($reservation->annonce->prix_journalier * ($reservation->date_debut->diffInDays($reservation->date_fin) + 1), 2) }} MAD
                        </span>
                    </div>
                </div>
                
                <!-- Boutons -->
                <div class="flex justify-between">
                    <a href="{{ url()->previous() }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition">
                        Retour
                    </a>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                        Confirmer et payer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const basePrice = {{ $reservation->annonce->prix_journalier * ($reservation->date_debut->diffInDays($reservation->date_fin) + 1) }};
        const deliveryRadio = document.getElementById('avec_livraison');
        const noDeliveryRadio = document.getElementById('sans_livraison');
        const finalTotal = document.getElementById('finalTotal');
        const deliveryCost = document.getElementById('deliveryCost');
        
        function updateTotal() {
            if (deliveryRadio.checked) {
                const delivery = 20; // Montant fixe de 20 DH
                finalTotal.textContent = (basePrice + delivery).toFixed(2) + ' MAD';
                deliveryCost.textContent = '+20.00 MAD'; // Texte fixe
            } else {
                finalTotal.textContent = basePrice.toFixed(2) + ' MAD';
            }
        }
        
        deliveryRadio.addEventListener('change', updateTotal);
        noDeliveryRadio.addEventListener('change', updateTotal);
    });
</script>
@endsection