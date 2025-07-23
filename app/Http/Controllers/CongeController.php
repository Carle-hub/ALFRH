<?php
namespace App\Http\Controllers;

use App\Models\Conge;
use App\Models\Employe;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class CongeController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Pour les requêtes AJAX/JSON, retourner les données avec les relations
            if ($request->wantsJson() || $request->ajax()) {
                // Utiliser leftJoin pour récupérer tous les congés, même sans employé lié
                $conges = \App\Models\Conge::with(['employe', 'user'])
                    ->orderByDesc('id')
                    ->get();
                
                // Ajouter des logs pour déboguer
                \Log::info('Nombre de congés trouvés: ' . $conges->count());
                
                return response()->json($conges);
            }
           
            // Pour les vues normales
            $conges = Conge::with(['employe', 'user'])->get();
            $employes = Employe::orderBy('nom')->get();
            return view('conges.index', compact('conges', 'employes'));
            
        } catch (\Exception $e) {
            \Log::error('Erreur dans CongeController@index: ' . $e->getMessage());
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'error' => 'Erreur lors du chargement des congés',
                    'message' => $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Erreur lors du chargement des congés');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'employe_id' => 'required|integer|exists:employes,id',
                'date_debut' => 'required|date',
                'date_fin' => 'required|date|after_or_equal:date_debut',
                'commentaire' => 'nullable|string',
                'semestre' => 'nullable|string|max:20',
            ]);

            // Vérification : un employé ne peut prendre qu'un seul congé "Semestre 1"
            if (isset($validated['semestre']) && $validated['semestre'] === 'Semestre 1') {
                // Vérifier que la date_debut est entre janvier et juin
                $moisDebut = Carbon::parse($validated['date_debut'])->month;
                if ($moisDebut < 1 || $moisDebut > 6) {
                    return response()->json([
                        'message' => 'Pour le Semestre 1, la date de début doit être comprise entre janvier et juin.',
                        'errors' => [
                            'date_debut' => [
                                'Pour le Semestre 1, la date de début doit être comprise entre janvier et juin.'
                            ]
                        ]
                    ], 422);
                }
                // Correction : vérifier par année
                $annee = Carbon::parse($validated['date_debut'])->year;
                $exists = \App\Models\Conge::where('employe_id', $validated['employe_id'])
                    ->where('semestre', 'Semestre 1')
                    ->whereYear('date_debut', $annee)
                    ->exists();
                if ($exists) {
                    return response()->json([
                        'message' => 'Cet emplyoye ne peut plus avoir de conge pour semestre1 cette année',
                        'errors' => [
                            'semestre' => [
                                'Cet emplyoye ne peut plus avoir de conge pour semestre1 cette année'
                            ]
                        ]
                    ], 422);
                }
                $validated['duree'] = 12;
                $validated['solde_conges'] = 0; // <-- Mettre 0 au lieu de null
            } else if (isset($validated['semestre']) && $validated['semestre'] === 'Semestre 2') {
                // Vérifier que la date_debut est entre juillet et décembre
                $moisDebut = Carbon::parse($validated['date_debut'])->month;
                if ($moisDebut < 7 || $moisDebut > 12) {
                    return response()->json([
                        'message' => 'Pour le Semestre 2, la date de début doit être comprise entre juillet et décembre.',
                        'errors' => [
                            'date_debut' => [
                                'Pour le Semestre 2, la date de début doit être comprise entre juillet et décembre.'
                            ]
                        ]
                    ], 422);
                }

                // Récupérer tous les congés semestre 2 de l'année en cours pour cet employé
                $annee = Carbon::parse($validated['date_debut'])->year;
                $congesS2 = \App\Models\Conge::where('employe_id', $validated['employe_id'])
                    ->where('semestre', 'Semestre 2')
                    ->whereYear('date_debut', $annee)
                    ->orderBy('date_debut')
                    ->get();

                // Limiter à 2 congés Semestre 2 par an
                if ($congesS2->count() >= 2) {
                    return response()->json([
                        'message' => 'Un employé ne peut pas avoir plus de 2 congés pour le Semestre 2 sur une année donnée.',
                        'errors' => [
                            'semestre' => [
                                'Un employé ne peut pas avoir plus de 2 congés pour le Semestre 2 sur une année donnée.'
                            ]
                        ]
                    ], 422);
                }

                // Calculer la durée demandée
                $dateDebut = Carbon::parse($validated['date_debut']);
                $dateFin = Carbon::parse($validated['date_fin']);
                $dureeDemandee = $dateDebut->diffInDays($dateFin) + 1;

                // Calcul du solde déjà consommé sur Semestre 2 cette année
                $totalPris = $congesS2->sum('duree');
                $soldeRestant = 12 - $totalPris;

                if ($soldeRestant <= 0) {
                    // Il a déjà vidé son solde, il ne peut demander que 2 jours max, qui seront déduits de l'année suivante
                    if ($dureeDemandee > 2) {
                        return response()->json([
                            'message' => 'Solde Semestre 2 épuisé, vous ne pouvez demander que 2 jours maximum (qui seront déduits de l\'année suivante).',
                            'errors' => ['duree' => ['Solde Semestre 2 épuisé, vous ne pouvez demander que 2 jours maximum.']]
                        ], 422);
                    }
                    $validated['duree'] = $dureeDemandee;
                    $validated['solde_conges'] = 0;
                    // Pas de commentaire automatique ajouté ici
                } else {
                    // Il lui reste du solde, il ne peut pas dépasser ce solde
                    if ($dureeDemandee > $soldeRestant) {
                        return response()->json([
                            'message' => 'Vous ne pouvez pas demander plus que votre solde restant pour le semestre 2 (' . $soldeRestant . ' jour(s) restant(s)).',
                            'errors' => ['duree' => ['Vous ne pouvez pas demander plus que votre solde restant pour le semestre 2 (' . $soldeRestant . ' jour(s) restant(s)).']]
                        ], 422);
                    }
                    // Il prend sur son solde restant
                    $validated['duree'] = $dureeDemandee;
                    $validated['solde_conges'] = $soldeRestant - $dureeDemandee;
                }
            } else {
                // Calculer la durée en jours pour Semestre 2 ou autre
                $dateDebut = Carbon::parse($validated['date_debut']);
                $dateFin = Carbon::parse($validated['date_fin']);
                $validated['duree'] = $dateDebut->diffInDays($dateFin) + 1;
                if ($validated['duree'] > 12) {
                    return response()->json([
                        'message' => 'La durée ne peut pas dépasser 12 jours.',
                        'errors' => ['duree' => ['La durée ne peut pas dépasser 12 jours.']]
                    ], 422);
                }
                $validated['solde_conges'] = max(0, 12 - $validated['duree']);
            }

            // Ajouter les champs automatiques
            $validated['users_id'] = auth()->id();
            $validated['date_approbation'] = now();

            // Créer le congé
            $conge = Conge::create($validated);

            // Charger la relation employe et user pour la réponse JSON
            $conge->load(['employe', 'user']);

            \Log::info('Congé créé avec succès: ', $conge->toArray());
           
            return response()->json($conge, 201);
           
        } catch (ValidationException $e) {
            \Log::error('Erreur de validation: ', $e->errors());
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création du congé: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erreur lors de la création du congé',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $conge = Conge::find($id);
        if (!$conge) {
            return response()->json(['message' => 'Congé introuvable'], 404);
        }
        try {
            $conge->delete();
            return response()->json(['message' => 'Congé supprimé avec succès']);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la suppression du congé: ' . $e->getMessage());
            return response()->json(['message' => 'Erreur lors de la suppression du congé', 'error' => $e->getMessage()], 500);
        }
    }
    /**
     * Update the specified conge in storage.
     */
    public function update(Request $request, $id)
    {
        $conge = Conge::find($id);
        if (!$conge) {
            return response()->json(['message' => 'Congé introuvable'], 404);
        }
        try {
            $validated = $request->validate([
                'employe_id' => 'required|integer|exists:employes,id',
                'date_debut' => 'required|date',
                'date_fin' => 'required|date|after_or_equal:date_debut',
                'commentaire' => 'nullable|string',
                'semestre' => 'nullable|string|max:20',
            ]);

            $conge->update($validated);
            $conge->refresh();
            $conge->load(['employe', 'user']);
            return response()->json($conge);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la modification du congé',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}