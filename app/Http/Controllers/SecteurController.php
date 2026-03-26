<?php

namespace App\Http\Controllers;

use App\Models\Secteur;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\programme;
use App\Models\Plan;
use App\Models\Activity;
use App\Models\SubActivity;
use App\Models\Task;
use App\Exceptions\UnauthorizedException;
class SecteurController extends Controller
{
    public function __construct()
    {
        // Vérifier les permissions
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->can('voir les secteurs')) {
                throw new UnauthorizedException();
            }
            return $next($request);
        })->only(['index', 'show']);
    
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->can('créer des secteurs')) {
                throw new UnauthorizedException();
            }
            return $next($request);
        })->only(['create', 'store']);
    
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->can('modifier les secteurs')) {
                throw new UnauthorizedException();
            }
            return $next($request);
        })->only(['edit', 'update']);
    
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->can('supprimer les secteurs')) {
                throw new UnauthorizedException();
            }
            return $next($request);
        })->only(['destroy']);
    }

    public function index()
    {
        // Paginer les secteurs
        $secteurs = Secteur::paginate(8); // Modifier 3 selon vos besoins
        return view('secteurs.index', compact('secteurs'));
    }

    public function create()
    {
        return view('secteurs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
        ]);

        $secteur = Secteur::create($request->all());

        if ($request->ajax()) {
            return response()->json([
                'success' => 'Secteur créé avec succès',
                'secteur' => $secteur,
            ]);
        }

        return redirect()->route('secteurs.index')->with('success', 'Secteur créé avec succès');
    }

    public function edit(Secteur $secteur)
    {
        return view('secteurs.edit', compact('secteur'));
    }

    public function update(Request $request, Secteur $secteur)
    {
        $request->validate([
            'nom' => 'required',
        ]);

        $secteur->update($request->all());
        return redirect()->route('secteurs.index')->with('success', 'Secteur mis à jour avec succès');
    }

    public function destroy(Secteur $secteur)
    {
        $secteur->delete();
        return redirect()->route('secteurs.index')->with('success', 'Secteur supprimé avec succès');
    }

    public function show(Secteur $secteur)
    {
        // Charger les programmes associés
        $secteur = Secteur::with('programmes')->findOrFail($secteur->id);
        $programmes = $secteur->programmes;

        return view('secteurs.show', compact('secteur', 'programmes'));
    }

    public function programmes(Secteur $secteur)
    {
        // Charger les programmes associés au secteur
        $programmes = $secteur->programmes;
        return view('secteurs.programmes', compact('secteur', 'programmes'));
    }

    public function loadProgrammes($id)
    {
        $secteur = Secteur::findOrFail($id);
        $programmes = $secteur->programmes()->select('id', 'title', )->get();
        return response()->json($programmes);
    }
}
