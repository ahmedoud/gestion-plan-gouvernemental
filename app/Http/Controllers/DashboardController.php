<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Secteur;
use App\Models\Programme;
use App\Models\User;
use App\Models\Plan;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Utilisateur connecté

        // Charger les secteurs avec leurs programmes
        $secteurs = Secteur::with('programmes')->get();

        // Si l'utilisateur est associé à des tâches, filtrer les programmes
        if ($user->tasks()->exists()) {
            $programmes = Programme::whereHas('plans.tasks.users', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })->get();
        } else {
            // Sinon, ne pas afficher de programmes
            $programmes = collect(); // Une collection vide
        }

        // Compteurs pour les cartes
        $usersCount = User::count();
        $secteursCount = $secteurs->count();
        $programmesCount = $programmes->count();
        $plansCount = Plan::count();

        // Retourner la vue avec les secteurs, programmes et compteurs
        return view('dashboard', compact('usersCount', 'secteursCount', 'programmesCount', 'plansCount', 'secteurs', 'programmes'));
    }

    public function users()
    {
        $users = User::all();
        return response()->json(view('dashboard', compact('users'))->render());
    }

    public function secteurs()
    {
        $secteurs = Secteur::all();
        return response()->json(view('dashboard', compact('secteurs'))->render());
    }

    public function defaultContent()
    {
        return view('partials.default_dashboard_content');
    }
}