<div>
    <label class="block text-sm font-medium mb-1">Nom</label>
    <input type="text" name="nom" value="{{ old('nom', $product->nom ?? '') }}" class="w-full border rounded px-3 py-2" required>
</div>

<div>
    <label class="block text-sm font-medium mb-1">Description</label>
    <textarea name="description" class="w-full border rounded px-3 py-2">{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div>
    <label class="block text-sm font-medium mb-1">Ville</label>
    <input type="text" name="ville" value="{{ old('ville', $product->ville ?? '') }}" class="w-full border rounded px-3 py-2" required>
</div>

<div>
    <label class="block text-sm font-medium mb-1">Prix journalier (MAD)</label>
    <input type="number" name="prix_journalier" value="{{ old('prix_journalier', $product->prix_journalier ?? '') }}" step="0.01" class="w-full border rounded px-3 py-2" required>
</div>

<div>
    <label class="block text-sm font-medium mb-1">État</label>
    <input type="text" name="etat" value="{{ old('etat', $product->etat ?? '') }}" class="w-full border rounded px-3 py-2" required>
</div>

<div>
    <label class="block text-sm font-medium mb-1">Catégorie</label>
    <select name="categorie_id" class="w-full border rounded px-3 py-2" required>
        <option value="">-- Choisir une catégorie --</option>
        @foreach($categories as $categorie)
            <option value="{{ $categorie->id }}" {{ old('categorie_id', $product->categorie_id ?? '') == $categorie->id ? 'selected' : '' }}>
                {{ $categorie->nom }}
            </option>
        @endforeach
    </select>
</div>

<div>
    <label class="block text-sm font-medium mb-1">Image du produit</label>

    @if($product && $product->images->isNotEmpty())
        <div class="mb-2">
            <img src="{{ asset('storage/' . $product->images->first()->url) }}" alt="Image actuelle"
                 class="w-40 rounded border">
            <p class="text-xs text-gray-500 mt-1">Image actuelle — sera remplacée si une nouvelle est choisie</p>
        </div>
    @endif

    <input type="file" name="image" accept="image/*" class="w-full border rounded px-3 py-2">
</div>

