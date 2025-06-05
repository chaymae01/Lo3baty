<?php

namespace App\Http\Controllers\Partenaire\Product;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Objet;
use App\Models\Categorie;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id() ?? 1;

        $query = Objet::where('proprietaire_id', $userId)->with('categorie');

        if ($request->filled('categorie_id')) {
            $query->where('categorie_id', $request->categorie_id);
        }

        if ($request->filled('etat')) {
            $query->where('etat', $request->etat);
        }

        if ($request->filled('tranche_age')) {
            $query->where('tranche_age', $request->tranche_age);
        }

        if ($request->filled('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('sort_nom')) {
            if ($request->sort_nom === 'asc') {
                $query->orderBy('nom', 'asc');
            } elseif ($request->sort_nom === 'desc') {
                $query->orderBy('nom', 'desc');
            }
        }

        $products = $query->get();
        $categories = Categorie::all();

        return view('partenaire.products.index', compact('products', 'categories'));
    }


    public function create()
    {
        $categories = Categorie::all();
        return view('partenaire.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $userId = auth()->id() ?? 1;

        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ville' => 'required|string|max:255',
            'etat' => 'required|in:Neuf,Bon état,Usage',
            'tranche_age' => 'required|in:<3,3-5,6-8,9-12,13+',
            'categorie_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|max:2048', // max 2MB par image
        ]);

        $product = Objet::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'ville' => $request->ville,
            'etat' => $request->etat,
            'tranche_age' => $request->tranche_age,
            'categorie_id' => $request->categorie_id,
            'proprietaire_id' => $userId,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');

                Image::create([
                    'objet_id' => $product->id,
                    'url' => $path,
                ]);
            }
        }

        return redirect()->route('partenaire.products.index')->with('success', 'Produit ajouté avec succès.');
    }

    public function edit(Objet $product)
    {
        //$this->authorize('update', $product); // Optional if using policies
        $categories = Categorie::all();
        return view('partenaire.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Objet $product)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ville' => 'required|string|max:255',
            'etat' => 'required|in:Neuf,Bon état,Usage',
            'tranche_age' => 'required|in:<3,3-5,6-8,9-12,13+',
            'categorie_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|max:2048', // multiples images
        ]);

        $product->update($request->only([
            'nom', 'description', 'ville', 'etat', 'categorie_id', 'tranche_age'
        ]));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');

                Image::create([
                    'objet_id' => $product->id,
                    'url' => $path,
                ]);
            }
        }

        return redirect()->route('partenaire.products.index')->with('success', 'Produit modifié avec succès.');
    }


    public function destroy(Objet $product)
    {
        //$this->authorize('delete', $product); // Optional if using policies
        $product->delete();
        return redirect()->route('partenaire.products.index')->with('success', 'Produit supprimé avec succès.');
    }

    public function show(Objet $product)
    {
        $product->load('images', 'categorie');
        return view('partenaire.products.show', compact('product'));
    }

    public function deleteImage($id)
    {
        $image = Image::findOrFail($id);
        
        $image->delete();

        return back()->with('ok', 'Image supprimée avec succès.');
    }

}
