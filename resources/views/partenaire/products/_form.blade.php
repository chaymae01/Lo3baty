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
    <label class="block text-sm font-medium mb-1">État</label>
    <select name="etat" class="w-full border rounded px-3 py-2" required>
        <option value="">-- Sélectionner l'état --</option>
        <option value="Neuf" {{ old('etat', $product->etat ?? '') == 'Neuf' ? 'selected' : '' }}>Neuf</option>
        <option value="Bon état" {{ old('etat', $product->etat ?? '') == 'Bon état' ? 'selected' : '' }}>Bon état</option>
        <option value="Usage" {{ old('etat', $product->etat ?? '') == 'Usage' ? 'selected' : '' }}>Usé</option>
    </select>
</div>

<div>
    <label class="block text-sm font-medium mb-1">Tranche d'âge</label>
    <select name="tranche_age" class="w-full border rounded px-3 py-2" required>
        <option value="">-- Sélectionner --</option>
        <option value="<3" {{ old('tranche_age', $product->tranche_age ?? '') == '<3' ? 'selected' : '' }}>&lt; 3 ans</option>
        <option value="3-5" {{ old('tranche_age', $product->tranche_age ?? '') == '3-5' ? 'selected' : '' }}>3–5 ans</option>
        <option value="6-8" {{ old('tranche_age', $product->tranche_age ?? '') == '6-8' ? 'selected' : '' }}>6–8 ans</option>
        <option value="9-12" {{ old('tranche_age', $product->tranche_age ?? '') == '9-12' ? 'selected' : '' }}>9–12 ans</option>
        <option value="13+" {{ old('tranche_age', $product->tranche_age ?? '') == '13+' ? 'selected' : '' }}>13 ans et plus</option>
    </select>
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
    <label class="block text-sm font-medium mb-1">Images du produit</label>

    @if($product && $product->images->isNotEmpty())
        <div class="flex flex-wrap gap-3 mb-2">
            @foreach ($product->images as $img)
                <div class="relative">
                    <img src="{{ asset('storage/' . $img->url) }}" alt="Image actuelle" class="w-24 h-24 object-cover rounded border">
                    {{-- Ici tu pourrais ajouter un bouton pour supprimer chaque image individuellement plus tard --}}
                </div>
            @endforeach
        </div>
        <p class="text-xs text-gray-500 mt-1">Les nouvelles images s’ajouteront en plus des existantes.</p>
    @endif

    <input type="file" name="images[]" accept="image/*" class="w-full border rounded px-3 py-2" multiple>
    <p class="text-xs text-gray-500 mt-1">Vous pouvez sélectionner plusieurs images.</p>
</div>
