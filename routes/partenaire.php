<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Partenaire\Product\ProductController;
use App\Http\Controllers\Partenaire\PartenaireController;
use App\Http\Controllers\Partenaire\Annonce\AnnonceController;
use App\Http\Controllers\Partenaire\Reservation\ReservationController;
use App\Http\Controllers\Partenaire\Evaluation\EvaluationOnClientController;
use App\Http\Controllers\Partenaire\Evaluation\EvaluationOnPartnerController;
use App\Http\Controllers\Partenaire\DashboardController;
use App\Http\Controllers\Partenaire\ProfilController;
use App\Http\Controllers\Partenaire\RoleSwitchController;


Route::middleware(['auth', 'role:partenaire'])->prefix('partenaire')->name('partenaire.')->group(function () {

    // switch role route
    Route::post('/switch-to-client', [RoleSwitchController::class, 'switchToClient'])->name('switch.to.client');

    // Tableau de bord
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Produits – resource classique
    Route::resource('products', ProductController::class)
        ->parameters(['products' => 'product']);
    Route::delete('/products/images/{id}', [ProductController::class, 'deleteImage'])
        ->name('products.images.destroy');

    // Annonces
    Route::get('annonces/creerAnnonce', [AnnonceController::class, 'choose'])->name('annonces.choose');
    Route::get('annonces/creer/{objet}', [AnnonceController::class, 'createForObject'])->name('annonces.createForObject');
    Route::post('annonces/{annonce}/archiver', [AnnonceController::class, 'archiver'])->name('annonces.archiver');
    Route::post('annonces/{annonce}/activer', [AnnonceController::class, 'activer'])->name('annonces.activer');
    Route::resource('annonces', AnnonceController::class)
        ->except(['create'])
        ->parameters(['annonces' => 'annonce']);

    // Réservations
    Route::get('reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('reservations/{reservation}/valider', [ReservationController::class, 'valider'])->name('reservations.valider');
    Route::post('reservations/{reservation}/refuser', [ReservationController::class, 'refuser'])->name('reservations.refuser');

    // Évaluations sur clients
    Route::get('evaluations', [EvaluationOnClientController::class, 'index'])->name('evaluations.index');
    Route::get('evaluations/creer/{reservation}', [EvaluationOnClientController::class, 'create'])->name('evaluations.create');
    Route::post('evaluations', [EvaluationOnClientController::class, 'store'])->name('evaluations.store');

    // Évaluations sur le partenaire
    Route::get('/commentaires', [EvaluationOnPartnerController::class, 'commentaires'])->name('evaluations.commentaires');
    Route::post('/commentaires/{evaluation}/signaler', [EvaluationOnPartnerController::class, 'signaler'])->name('evaluations.signaler');
    Route::post('/commentaires/{evaluation}/unsignaler', [EvaluationOnPartnerController::class, 'unsignaler'])->name('evaluations.unsignaler');

    // Profil
    Route::get('profil', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('profil', [ProfilController::class, 'update'])->name('profil.update');
});
