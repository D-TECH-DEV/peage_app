<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paiement;
use App\Models\Guichet;
use App\Models\CategorieVehicule;
use App\Models\TypePaiement;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

        // High Level Metrics
        $recettesMois = Paiement::whereBetween('date_paiement', [$startOfMonth, $endOfMonth])->sum('montant');
        $recettesMoisDernier = Paiement::whereBetween('date_paiement', [$startOfLastMonth, $endOfLastMonth])->sum('montant');
        
        $percentChange = $recettesMoisDernier > 0 ? round((($recettesMois - $recettesMoisDernier) / $recettesMoisDernier) * 100, 1) : 100;
        
        $totalPassagesMois = Paiement::whereBetween('date_paiement', [$startOfMonth, $endOfMonth])->count();
        $guichetsActifs = Guichet::where('statut', 'Actif')->count();
        $totalGuichets = Guichet::count();
        
        $daysInMonthPassed = Carbon::now()->day;
        $recetteMoyenneJour = $daysInMonthPassed > 0 ? round($recettesMois / $daysInMonthPassed) : 0;

        // Chart Rendement Mensuel (Last 15 days)
        $rendementLabels = [];
        $rendementData = [];
        for ($i = 14; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $rendementLabels[] = $date->format('d/m');
            // Scale to thousands (k F) as per chart mock
            $sum = Paiement::whereDate('date_paiement', $date->format('Y-m-d'))->sum('montant');
            $rendementData[] = round($sum / 1000);
        }

        // Chart Vehicules
        $categories = CategorieVehicule::withCount(['paiements' => function ($q) use ($startOfMonth, $endOfMonth) {
            $q->whereBetween('date_paiement', [$startOfMonth, $endOfMonth]);
        }])->get();
        $vehiculesLabels = $categories->pluck('libelle')->toArray();
        $vehiculesData = $categories->pluck('paiements_count')->toArray();

        // Recent transactions
        $recentTransactions = Paiement::with(['categorieVehicule', 'guichet', 'typePaiement'])->orderBy('date_paiement', 'desc')->take(6)->get();

        // Modes de Paiement percentages
        $totalPassagesForPercentages = $totalPassagesMois > 0 ? $totalPassagesMois : 1;
        $modesPaiement = TypePaiement::withCount(['paiements' => function ($q) use ($startOfMonth, $endOfMonth) {
            $q->whereBetween('date_paiement', [$startOfMonth, $endOfMonth]);
        }])->get();
        
        $colors = ['#1D9E75', '#378ADD', '#BA7517', '#9CA3AF', '#5DCAA5', '#888888'];
        $modesStats = [];
        $i = 0;
        foreach ($modesPaiement as $mode) {
            $modesStats[] = [
                'libelle' => $mode->libelle,
                'count' => $mode->paiements_count,
                'percent' => round(($mode->paiements_count / $totalPassagesForPercentages) * 100),
                'color' => $colors[$i % count($colors)]
            ];
            $i++;
        }
        
        // Sort descending by count
        usort($modesStats, function($a, $b) { return $b['count'] <=> $a['count']; });

        // Performance Guichets
        $guichets = Guichet::withSum(['paiements' => function ($q) use ($startOfMonth, $endOfMonth) {
            $q->whereBetween('date_paiement', [$startOfMonth, $endOfMonth]);
        }], 'montant')->get()
        ->map(function ($guichet) use ($recettesMois) {
            $guichet->paiements_sum_montant = $guichet->paiements_sum_montant ?? 0;
            $guichet->percent = $recettesMois > 0 ? round(($guichet->paiements_sum_montant / $recettesMois) * 100) : 0;
            return $guichet;
        });
        
        // Sort by sum amount descending
        $performancesGuichets = $guichets->sortByDesc('paiements_sum_montant');
        
        $currentGuichet = Guichet::find(session('guichet_id'));

        return view('admin.dashboard', compact(
            'recettesMois', 'percentChange', 'totalPassagesMois', 'guichetsActifs', 'totalGuichets', 'recetteMoyenneJour',
            'rendementLabels', 'rendementData', 'vehiculesLabels', 'vehiculesData',
            'recentTransactions', 'modesStats', 'performancesGuichets', 'currentGuichet'
        ));
    }
}
