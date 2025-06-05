
@section('content')
<div class="container mx-auto py-8">
    <div class="flex items-center mb-8">
        <img src="{{ $utilisateur->image_profil ? asset('storage/' . $utilisateur->image_profil) : asset('images/default-profile.png') }}" 
             alt="Photo de profil" class="w-24 h-24 rounded-full mr-6">
        <div>
            <h1 class="text-3xl font-bold">{{ $utilisateur->nom }} {{ $utilisateur->prenom }}</h1>
            <p class="text-gray-600">Membre depuis {{ $utilisateur->created_at->format('d/m/Y') }}</p>
        </div>
    </div>

    <div class="mb-8">
        <h2 class="text-2xl font-semibold mb-4">À propos</h2>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <p class="text-gray-700">Email: {{ $utilisateur->email }}</p>
            @if($utilisateur->objets->count() > 0)
                <p class="mt-2">Objets à louer: {{ $utilisateur->objets->count() }}</p>
            @endif
        </div>
    </div>

    @if($commentaires->count() > 0)
    <div class="mb-8">
        <h2 class="text-2xl font-semibold mb-4">Commentaires reçus</h2>
        @foreach($commentaires as $commentaire)
            <div class="bg-white p-6 rounded-lg shadow-md mb-4">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <span class="font-semibold">{{ $commentaire->evaluateur->nom }}</span>
                        @if($commentaire->objet)
                        <span class="text-gray-600 text-sm ml-2">pour {{ $commentaire->objet->nom }}</span>
                        @endif
                    </div>
                    <div class="text-yellow-500">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= $commentaire->note ? '★' : '☆' }}
                        @endfor
                    </div>
                </div>
                <p class="text-gray-700">{{ $commentaire->commentaire }}</p>
                <div class="text-gray-500 text-sm mt-2">{{ $commentaire->created_at->diffForHumans() }}</div>
            </div>
        @endforeach
    </div>
    @else
    <div class="bg-blue-50 p-4 rounded-lg">
        <p>Ce propriétaire n'a pas encore reçu de commentaires.</p>
    </div>
    @endif
</div>
@endsection