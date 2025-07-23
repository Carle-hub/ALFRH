<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;

class EmployeController extends Controller
{
    // ...existing code...

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:employes,email,' . $id,
            'poste' => 'required|string|max:255',
            'departement' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:255',
        ]);

        $employe = Employe::find($id);

        if (!$employe) {
            return response()->json(['error' => 'Employé introuvable'], 404);
        }

        $employe->update($validated);

        return response()->json(['message' => 'Employé mis à jour avec succès', 'employe' => $employe]);
    }

    public function destroy($id)
    {
        $employe = Employe::find($id);
        if (!$employe) {
            return response()->json(['error' => 'Employé introuvable'], 404);
        }
        $employe->delete();
        return response()->json(['message' => 'Employé supprimé avec succès']);
    }
}