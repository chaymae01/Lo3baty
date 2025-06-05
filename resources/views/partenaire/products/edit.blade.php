@extends('layouts.partenaire')

@section('content')
<main id="dashboard-content" class="flex-1 p-8 overflow-y-auto">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg">
        <h1 class="text-3xl font-extrabold text-indigo-700 mb-6">
            {{ isset($product) ? 'Modifier le Produit' : 'Ajouter un Produit' }}
        </h1>

        <form action="{{ isset($product) ? route('partenaire.products.update', $product) : route('partenaire.products.store') }}"
              method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if(isset($product))
                @method('PUT')
            @endif

            @include('partenaire.products._form', ['product' => $product ?? null])

            <div class="text-right">
                <button type="submit"
                        class="inline-flex items-center bg-blue-500 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-600 transition">
                    {{ isset($product) ? 'Mettre à jour' : 'Enregistrer' }}
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
