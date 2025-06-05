<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AccueilController;
use App\Http\Controllers\ReservationHistoriqueController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AnnonceDetailsController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PartenaireController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\Partenaire_clientController;
use App\Http\Controllers\ClientStatsController;


use App\Http\Controllers\NotificationController;
Route::get('/notification-preferences', [NotificationController::class, 'getPreferences']);
Route::post('/notification-preferences', [NotificationController::class, 'savePreferences']);

// ========================
// Public Routes
// ========================

Route::middleware('guestany')->group(function () {
    Route::get('/', [AccueilController::class, 'index'])->name('acceuil');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/client/acceuil', [HomeController::class, 'clientHome'])->name('client.acceuil');

    //Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Surnom public access
Route::get('/utilisateur/surnom/{id}', [UtilisateurController::class,'getSurnom']);


// Paiement - public access
Route::get('/paiement', [PaiementController::class, 'show'])->name('paiement.show');
Route::post('/paiement/process', [PaiementController::class, 'process'])->name('paiement.process');

// ========================
// Protected Routes - User Must Be Logged In
// ========================
Route::middleware(['auth', 'role:client'])->group(function () {

    Route::post('/logout', [ProfileController::class, 'logout']);

    // Accès aux annonces & réservations
    Route::get('/annonces', [AnnonceController::class, 'index'])->name('annonces');
    Route::get('/annonces/{id}', [AnnonceDetailsController::class, 'show'])->name('annonceID');
    Route::get('/reservations', [ReservationHistoriqueController::class, 'reservations'])->name("reservations");
    Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');

    // Évaluation
    Route::get('/evaluation_annonce/{reservation}', [EvaluationController::class, 'create'])->name('evaluations.create');    
    Route::post('/evaluation_annonce', [EvaluationController::class, 'store'])->name('evaluations.store');

    // Réclamations

    Route::get('/client/reclamations', [ReclamationController::class, 'index'])->name('client.reclamations');
    Route::get('/reclamations', [ReclamationController::class, 'index'])->name('reclamations');
    Route::post('/reclamations', [ReclamationController::class, 'store'])->name('reclamations.store');

    Route::post('/profile/update-image', [ProfileController::class, 'updateImage']);
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword']);
    Route::post('/profile/update-info', [ProfileController::class, 'updateInfo']);


    // Client spécifique : réclamations visibles
    Route::get('/client/reclamations', [ReclamationController::class, 'index'])->name('client.reclamations');

    // Espace home + switch rôle
    Route::post('/switch-role', [PartenaireController::class, 'switchRole'])->name('switch.role');
    Route::get('/check-contract', [PartenaireController::class, 'checkContractStatus'])->name('partenaire.check');

    // Routes spécifiques aux clients
    Route::get('/devenir-partenaire', [PartenaireController::class, 'showContrat'])->name('partenaire.contrat');
    Route::post('/devenir-partenaire', [PartenaireController::class, 'devenirPartenaire'])->name('partenaire.valider');

    #stats
    Route::get('/client/stats', [ClientStatsController::class, 'show'])->name('stats');

});

