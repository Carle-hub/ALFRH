<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\Conge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SoldeCongeController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer tous les employés
        $employes = Employe::all();
        $annees = Conge::selectRaw('YEAR(date_debut) as annee')->distinct()->pluck('annee')->sort()->values()->toArray();

        $result = [];
        foreach ($employes as $emp) {
            $solde_report = 0; // solde reporté de l'année précédente
            foreach ($annees as $annee) {
                $sem1 = Conge::where('employe_id', $emp->id)
                    ->where('semestre', 'Semestre 1')
                    ->whereYear('date_debut', $annee)
                    ->sum('duree');
                $sem2 = Conge::where('employe_id', $emp->id)
                    ->where('semestre', 'Semestre 2')
                    ->whereYear('date_debut', $annee)
                    ->sum('duree');

                // Appliquer le report/déduction de l'année précédente
                $solde_restant = 12 - $sem2 + $solde_report;

                // Gestion du report/déduction pour l'année suivante
                if ($solde_restant < 0) {
                    $report_info = 'Déduction ' . abs($solde_restant) . ' jour(s) sur année ' . ($annee + 1);
                    $solde_report = $solde_restant; // négatif
                } elseif ($solde_restant > 0 && $sem2 > 0) {
                    $report_info = 'Report ' . $solde_restant . ' jour(s) sur année ' . ($annee + 1);
                    $solde_report = $solde_restant; // positif
                } elseif ($solde_restant == 0 && $sem2 > 0) {
                    $report_info = 'Solde épuisé';
                    $solde_report = 0;
                } else {
                    $report_info = '-';
                    $solde_report = 0;
                }

                $result[] = [
                    'employe_id' => $emp->id,
                    'nom' => $emp->nom,
                    'annee' => $annee,
                    'semestre1' => $sem1,
                    'semestre2' => $sem2,
                    'solde_restant' => $solde_restant,
                    'report_info' => $report_info,
                ];
            }
        }
        return response()->json($result);
    }
}
