@extends('layouts.partner')

@section('content')
<div class="p-6 max-w-2xl mx-auto bg-white shadow-md rounded">
    <h1 class="text-2xl font-semibold mb-4">{{ $product->nom }}</h1>
    

    @if($product->images->isNotEmpty())
        <div class="mb-6">
            <h2 class="text-sm text-gray-500 mb-2">Image du produit</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                @foreach($product->images as $image)
                    <img src="{{ asset('storage/' . $image->url) }}" alt="Image de {{ $product->nom }}" class="w-full h-48 object-cover rounded border" />
                @endforeach
            </div>
        </div>
    @else
        <p class="text-sm text-gray-400 italic mb-6">Aucune image pour ce produit.</p>
    @endif


    <dl class="space-y-3">
        <div>
            <dt class="text-sm text-gray-500">Description</dt>
            <dd class="text-gray-700">{{ $product->description }}</dd>
        </div>
        <div>
            <dt class="text-sm text-gray-500">Catégorie</dt>
            <dd class="text-gray-700">{{ $product->categorie->nom ?? '—' }}</dd>
        </div>
        <div>
            <dt class="text-sm text-gray-500">Ville</dt>
            <dd class="text-gray-700">{{ $product->ville }}</dd>
        </div>
        <div>
            <dt class="text-sm text-gray-500">Prix journalier</dt>
            <dd class="text-gray-700">{{ $product->prix_journalier }} MAD/j</dd>
        </div>
        <div>
            <dt class="text-sm text-gray-500">État</dt>
            <dd class="text-gray-700">{{ $product->etat }}</dd>
        </div>
    </dl>

    <div class="mt-6">
        <a href="{{ route('partner.products.index') }}" class="text-blue-500 hover:underline">← Retour</a>
    </div>
</div>
@endsection
