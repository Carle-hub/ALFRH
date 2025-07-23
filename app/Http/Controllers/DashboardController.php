<?php

namespace App\Http\Controllers;

use App\Models\Conge;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalConges = \App\Models\Conge::count();
        // ou adaptez selon la logique métier et les colonnes existantes

        return view('dashboard', compact('totalConges'));
    }
}