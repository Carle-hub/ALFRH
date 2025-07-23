<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\CongeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $totalEmployes = DB::table('employes')->count();
    $totalConges = DB::table('conges')->count();
    $totalRetards = DB::table('retards')->count();
    $totalAbsences = DB::table('absences')->count();
    $conges = \App\Models\Conge::with('employe')->get();
    return view('dashboard', compact('totalEmployes', 'totalConges', 'totalRetards', 'totalAbsences', 'conges'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Routes employés
    Route::get('/employes', function () {
        return response()->json(DB::table('employes')->get());
    });
    
    Route::post('/employes', function () {
        $data = request()->validate([
            'nom' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'poste' => 'nullable|string|max:255',
            'departement' => 'nullable|string|max:255',
            'adresse' => 'nullable|string',
            'telephone' => 'nullable|string|max:20',
        ]);
        
        $id = DB::table('employes')->insertGetId($data);
        $employe = DB::table('employes')->where('id', $id)->first();
        return response()->json($employe);
    });
    
    Route::patch('/employes/{id}', [EmployeController::class, 'update'])->name('employes.update');
    Route::delete('/employes/{id}', [EmployeController::class, 'destroy'])->name('employes.destroy');
    
    // Routes congés
    Route::get('/conges', [CongeController::class, 'index'])->name('conges.index');
    Route::post('/conges', [CongeController::class, 'store'])->name('conges.store');
    Route::put('/conges/{id}', [CongeController::class, 'update'])->name('conges.update');
    Route::patch('/conges/{id}', [CongeController::class, 'update']);
    Route::delete('/conges/{id}', [CongeController::class, 'destroy'])->name('conges.destroy')->middleware('auth');
    
    // Route pour le solde des congés
    Route::get('/solde-conges', [\App\Http\Controllers\SoldeCongeController::class, 'index']);
    
    // Routes absences (AJAX API)
    Route::get('/absences', [\App\Http\Controllers\AbsenceController::class, 'index'])->name('absences.index');
    Route::post('/absences', [\App\Http\Controllers\AbsenceController::class, 'store'])->name('absences.store');
    Route::delete('/absences/{id}', [\App\Http\Controllers\AbsenceController::class, 'destroy'])->name('absences.destroy');
});

require __DIR__.'/auth.php';