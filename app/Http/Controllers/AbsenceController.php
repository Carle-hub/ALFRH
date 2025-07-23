<?php
namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Employe;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AbsenceController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->wantsJson() || $request->ajax()) {
                $absences = Absence::with(['employe', 'user'])
                    ->orderByDesc('id')
                    ->get();
                return response()->json($absences);
            }
            $absences = Absence::with(['employe', 'user'])->get();
            $employes = Employe::orderBy('nom')->get();
            return view('absences.index', compact('absences', 'employes'));
        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'error' => 'Erreur lors du chargement des absences',
                    'message' => $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Erreur lors du chargement des absences');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'employe_id' => 'required|integer|exists:employes,id',
                'type' => 'required|string|max:50',
                'date_debut' => 'required|date',
                'date_retour' => 'required|date|after_or_equal:date_debut',
                'duree' => 'required|integer|min:1',
                'justification' => 'nullable|string|max:255',
                'users_id' => 'nullable|integer|exists:users,id',
                'date_approbation' => 'nullable|date',
            ]);
            $validated['users_id'] = auth()->id();
            $validated['date_approbation'] = now();

            $absence = Absence::create($validated);
            $absence->load(['employe', 'user']);

            return response()->json($absence, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la création de l\'absence',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $absence = Absence::find($id);
        if (!$absence) {
            return response()->json(['message' => 'Absence introuvable'], 404);
        }
        try {
            $absence->delete();
            return response()->json(['message' => 'Absence supprimée avec succès']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la suppression de l\'absence', 'error' => $e->getMessage()], 500);
        }
    }
}