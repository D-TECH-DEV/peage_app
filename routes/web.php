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
use Illuminate\Support\Facades\Hash;

// ROUTES FRONTEND
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return redirect(route('admin.dashboard'));
});

Route::get('/tarifs', [TarifController::class, 'index'])->name('frontend.tarifs.index');
Route::get('/guichets', [GuichetController::class, 'index'])->name('frontend.guichets.index');

// ROUTES BACKEND
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/export', [App\Http\Controllers\DashboardController::class, 'exportStats'])->name('dashboard.export');

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
    Route::get('paiements/export', [PaiementController::class, 'exportCsv'])->name('paiements.export');
    Route::resource('paiements', PaiementController::class);
    Route::resource('tarifs', TarifController::class);
    Route::resource('types-paiements', TypePaiementController::class);

});
