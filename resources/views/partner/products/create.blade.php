@extends('layouts.partner')

@section('content')
<div class="p-6 max-w-xl mx-auto">
    <h1 class="text-2xl font-semibold mb-6">Ajouter un Produit</h1>

    <form action="{{ route('partner.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        @include('partner.products._form', ['product' => null])

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Enregistrer</button>
    </form>
</div>
@endsection
