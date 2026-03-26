<?php

namespace App\Http\Controllers;

use App\Models\Programme;
use App\Models\Secteur;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Activity;
use App\Models\SubActivity;
use App\Models\Task;
use App\Models\Comment;
use Barryvdh\DomPDF\Facade\Pdf; // N'oubliez pas d'ajouter cet import
use App\Exceptions\UnauthorizedException;

class ProgrammeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Assurez-vous que l'utilisateur est authentifié avant d'accéder à toute fonctionnalité
    }

    public function index(Request $request)
    {
        // Vérifie si l'utilisateur a la permission de voir les programmes
        if (!auth()->user()->can('voir les programmes')) {
            throw new UnauthorizedException();
        }

        $programmes = Programme::all();
        return view('programmes.index', compact('programmes'));
    }

    public function create()
    {
        // Vérifie si l'utilisateur a la permission de créer un programme
        if (!auth()->user()->can('créer des programmes')) {
            throw new UnauthorizedException();
        }

        $secteurs = Secteur::all();
        return view('programmes.create', compact('secteurs'));
    }

    public function store(Request $request)
    {
        // Vérifie si l'utilisateur a la permission de créer un programme
        if (!auth()->user()->can('créer des programmes')) {
            throw new UnauthorizedException();
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date_format:d/m/Y',
            'end_date' => 'required|date_format:d/m/Y|after_or_equal:start_date',
            'secteur_id' => 'required|exists:secteurs,id',
        ]);

        Programme::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d'),
            'end_date' => Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d'),
            'secteur_id' => $request->secteur_id,
        ]);

        return redirect()->route('programmes.index')->with('success', 'Programme créé avec succès.');
    }

    public function edit(Programme $programme)
    {
        // Vérifie si l'utilisateur a la permission de modifier un programme
        if (!auth()->user()->can('modifier les programmes')) {
            throw new UnauthorizedException();
        }

        $secteurs = Secteur::all();
        return view('programmes.edit', compact('programme', 'secteurs'));
    }

    public function update(Request $request, $id)
    {
        // Vérifie si l'utilisateur a la permission de modifier un programme
        if (!auth()->user()->can('modifier les programmes')) {
            throw new UnauthorizedException();
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date_format:d/m/Y',
            'end_date' => 'required|date_format:d/m/Y|after_or_equal:start_date',
            'secteur_id' => 'required|exists:secteurs,id',
        ]);

        $programme = Programme::findOrFail($id);

        $programme->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d'),
            'end_date' => Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d'),
            'secteur_id' => $request->secteur_id,
        ]);

        return redirect()->route('programmes.index')->with('success', 'Programme mis à jour avec succès.');
    }

    public function destroy($id)
    {
        // Vérifie si l'utilisateur a la permission de supprimer un programme
        if (!auth()->user()->can('supprimer les programmes')) {
            throw new UnauthorizedException();
        }

        $programme = Programme::findOrFail($id);
        $programme->delete();

        return redirect()->route('programmes.index')->with('success', 'Programme supprimé avec succès.');
    }

    public function archive(Programme $programme)
    {
        // Vérifie si l'utilisateur a la permission d'archiver un programme
        if (!auth()->user()->can('Archiver des programmes')) {
            throw new UnauthorizedException();
        }

        $programme->status = $programme->status === 'archived' ? 'active' : 'archived';
        $programme->save();

        return redirect()->route('programmes.index')->with('success', $programme->status === 'archived' ? 'Programme archivé avec succès.' : 'Programme désarchivé avec succès.');
    }

    public function show($id)
    {
        $programme = Programme::findOrFail($id);
        $comments = $programme->comments;

        // Vérifie si l'utilisateur a la permission de voir un programme
        if (!auth()->user()->can('voir les programmes')) {
            throw new UnauthorizedException();
        }

        return view('programmes.show', compact('programme', 'comments'));
    }

    public function addComment(Request $request, $programmeId)
    {
        // Vérifie si l'utilisateur a la permission d'ajouter un commentaire
        if (!auth()->user()->can('voir les programmes')) {
            throw new UnauthorizedException();
        }

        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        Comment::create([
            'programme_id' => $programmeId,
            'plan_id' => null,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return redirect()->route('programmes.show', $programmeId)->with('success', 'Commentaire ajouté pour le programme.');
    }

    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);

        // Vérifie si l'utilisateur a la permission de supprimer un commentaire
        if (!auth()->user()->can('supprimer les commentaires')) {
            throw new UnauthorizedException();
        }

        if (auth()->id() !== $comment->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Non autorisé');
        }

        $comment->delete();

        return back()->with('success', 'Commentaire supprimé avec succès.');
    }

    public function plans($id)
    {
        // Vérifie si l'utilisateur a la permission de voir les plans
        if (!auth()->user()->can('voir les plans')) {
            throw new UnauthorizedException();
        }

        $programme = Programme::findOrFail($id);
        $plans = $programme->plans;

        return view('programmes.plans', compact('programme', 'plans'));
    }

    public function showPlans($programmeId)
    {
        // Vérifie si l'utilisateur a la permission de voir les plans
        if (!auth()->user()->can('voir les plans')) {
            throw new UnauthorizedException();
        }

        $programme = Programme::with('plans.activities')->findOrFail($programmeId);
        $plans = $programme->plans;

        return view('programmes.plans', compact('programme', 'plans'));
    }

    public function unarchive($id)
    {
        // Vérifie si l'utilisateur a la permission de désarchiver un programme
        if (!auth()->user()->can('Archiver des programmes')) {
            throw new UnauthorizedException();
        }

        $plan = Plan::findOrFail($id);
        $plan->status = 'active';
        $plan->save();

        return redirect()->back()->with('success', 'Plan désarchivé avec succès.');
    }

    public function loadPlans($id)
    {
        $plans = Plan::where('programme_id', $id)->get(['id', 'title']);
        if ($plans->isEmpty()) {
            return response()->json([], 404);
        }
        return response()->json($plans);
    }

    public function generateReport($id)
    {
        // Vérifie si l'utilisateur a la permission de générer un rapport
        if (!auth()->user()->can('voir les programmes')) {
            throw new UnauthorizedException();
        }

        $programme = Programme::with(['plans.activities.subActivities.tasks'])->findOrFail($id);

        $data = [
            'programme' => $programme,
        ];

        $pdf = PDF::loadView('reports.programme_report', $data);
        return $pdf->download('rapport_programme_' . $programme->id . '.pdf');
    }
}