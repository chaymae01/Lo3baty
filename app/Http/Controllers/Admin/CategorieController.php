<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');
    
    $categories = Categorie::when($search, function ($query, $search) {
        return $query->where('nom', 'like', "%{$search}%");
    })
    ->paginate(9);
    
    return view('admin.categories.index', compact('categories'));
}

    public function show(Categorie $categorie)
    {
        return view('admin.categories.show', compact('categorie'));
    }

    public function edit(Categorie $categorie)
    {
        return view('admin.categories.edit', compact('categorie'));
    }
public function destroy(Categorie $categorie)
{
    try {
        $categorie->delete();
        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie supprimée avec succès');
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
    }
}
    public function update(Request $request, Categorie $categorie)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:categories,nom,'.$categorie->id,
        ]);

        $categorie->update([
            'nom' => $request->nom,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie mise à jour avec succès');
    }
    public function create()
{
    return view('admin.categories.create');
}

public function store(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255|unique:categories,nom',
    ]);

    Categorie::create($request->all());

    return redirect()->route('admin.categories.index')
        ->with('success', 'Catégorie créée avec succès');
}
}