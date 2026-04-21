<?php

use Illuminate\Support\Facades\Route;

// Importation de tous les contrôleurs
use App\Http\Controllers\CategorieVehiculeController;
use App\Http\Controllers\GuichetController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\TypePaiementController;
use App\Http\Controllers\UserController;




Route::get('/', function () {
    return 'Bienvenue sur la page d\'accueil (Frontend) du Péage';
});


Route::get('/tarifs', [TarifController::class, 'index'])->name('frontend.tarifs.index');
Route::get('/guichets', [GuichetController::class, 'index'])->name('frontend.guichets.index');



Route::prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/', function () {
        return 'Tableau de bord de l\'Administration (Backend)';
    })->name('dashboard');

    Route::resource('users', UserController::class);
    Route::resource('categories-vehicules', CategorieVehiculeController::class);
    Route::resource('guichets', GuichetController::class);
    Route::resource('paiements', PaiementController::class);
    Route::resource('tarifs', TarifController::class);
    Route::resource('types-paiements', TypePaiementController::class);

});
