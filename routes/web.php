<?php

use Illuminate\Support\Facades\Route;

// Importation de tous les contrôleurs
use App\Http\Controllers\CategorieVehiculeController;
use App\Http\Controllers\GuichetController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\TypePaiementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Models\User;

// ROUTES FRONTEND
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return 'Bienvenue sur la page d\'accueil (Frontend) du Péage';
});

Route::get('/tarifs', [TarifController::class, 'index'])->name('frontend.tarifs.index');
Route::get('/guichets', [GuichetController::class, 'index'])->name('frontend.guichets.index');

// ROUTES BACKEND
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/rapports', function() {
        return view('admin.rapports.index');
    })->name('rapports.index');

    Route::get('/settings', function() {
        $categories = \App\Models\CategorieVehicule::all();
        $types = \App\Models\TypePaiement::all();
        $tarifs = \App\Models\Tarif::with('categorieVehicule')->get();
        return view('admin.settings.index', compact('categories', 'types', 'tarifs'));
    })->name('settings.index');

    Route::resource('users', UserController::class);
    Route::resource('categories-vehicules', CategorieVehiculeController::class);
    Route::resource('guichets', GuichetController::class);
    Route::get('paiements/{paiement}/receipt', [PaiementController::class, 'receipt'])->name('paiements.receipt');
    Route::resource('paiements', PaiementController::class);
    Route::resource('tarifs', TarifController::class);
    Route::resource('types-paiements', TypePaiementController::class);

});
