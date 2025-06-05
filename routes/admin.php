<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\Partenaire_clientController;

// Admin Authentication - login only
Route::middleware('guest:admin')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
});

// ========================
// Admin Routes - Protected by 'auth:admin'
// ========================
Route::prefix('admin')//->middleware(['auth:admin'])
        ->name('admin.')->group(function () {

    // Admin logout
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('Adminlogout');

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Clients
    Route::get('/clients', [Partenaire_clientController::class, 'indexClients'])->name('clients');
    Route::post('/clients/{client}/toggle-status', [Partenaire_clientController::class, 'toggleStatusClient'])->name('clients.toggle-status');

    // Partenaires
    Route::get('/partenaires', [Partenaire_clientController::class, 'indexPartenaires'])->name('partenaires');
    Route::post('/partenaires/{partenaire}/toggle-status', [Partenaire_clientController::class, 'toggleStatusPartenaire'])->name('partenaires.toggle-status');


    Route::get('/commentaires', [\App\Http\Controllers\Admin\CommentaireController::class, 'index'])->name('commentaires');
    Route::get('/commentaires/{id}', [\App\Http\Controllers\Admin\CommentaireController::class, 'show'])->name('commentaires.show');
    Route::post('/commentaires/{id}/approve', [\App\Http\Controllers\Admin\CommentaireController::class, 'approve'])->name('commentaires.approve'); 
    Route::delete('/commentaires/{id}', [\App\Http\Controllers\Admin\CommentaireController::class, 'destroy'])->name('commentaires.destroy');


    Route::get('/paiements', [\App\Http\Controllers\Admin\PaiementController::class, 'index'])
        ->name('paiements');

    Route::get('/paiements/export', [\App\Http\Controllers\Admin\PaiementController::class, 'export'])
        ->name('paiements.export');


    Route::prefix('annonces')->group(function() {
        Route::get('/', [\App\Http\Controllers\Admin\AnnonceController::class, 'index'])->name('annonces.index');
        Route::get('/{annonce}', [\App\Http\Controllers\Admin\AnnonceController::class, 'show'])->name('annonces.show');
    });
    
    Route::prefix('reservations')->group(function() {
        Route::get('/', [\App\Http\Controllers\Admin\ReservationController::class, 'index'])->name('reservations.index');
        Route::get('/{reservation}', [\App\Http\Controllers\Admin\ReservationController::class, 'show'])->name('reservations.show');
    });

    Route::prefix('reclamations')->name('reclamations.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ReclamationController::class, 'index'])->name('index');
        Route::get('/{reclamation}', [\App\Http\Controllers\Admin\ReclamationController::class, 'show'])->name('show');
        Route::post('/{reclamation}/repondre', [\App\Http\Controllers\Admin\ReclamationController::class, 'repondre'])->name('repondre');
        Route::get('/{reclamation}/download', [\App\Http\Controllers\Admin\ReclamationController::class, 'downloadPieceJointe'])->name('download');
    });

 Route::prefix('categories')->group(function() {
        Route::get('/', [\App\Http\Controllers\Admin\CategorieController::class, 'index'])->name('categories.index');
        Route::get('/create', [\App\Http\Controllers\Admin\CategorieController::class, 'create'])->name('categories.create');
        Route::post('/', [\App\Http\Controllers\Admin\CategorieController::class, 'store'])->name('categories.store');
        Route::get('/{categorie}', [\App\Http\Controllers\Admin\CategorieController::class, 'show'])->name('categories.show');
        Route::get('/{categorie}/edit', [\App\Http\Controllers\Admin\CategorieController::class, 'edit'])->name('categories.edit');
        Route::put('/{categorie}', [\App\Http\Controllers\Admin\CategorieController::class, 'update'])->name('categories.update');
        Route::delete('/{categorie}', [\App\Http\Controllers\Admin\CategorieController::class, 'destroy'])->name('categories.destroy');
    });

});