<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Programme;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Comment;
use App\Models\Activity;
use App\Models\SubActivity;
use App\Models\Task;
use App\Exceptions\UnauthorizedException;

class PlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Vérifie si l'utilisateur a la permission de voir les plans
        if (!auth()->user()->can('voir les plans')) {
            throw new UnauthorizedException();
        }

        $plans = Plan::all();
        return view('plans.index', compact('plans'));
    }

    public function create()
    {
        // Vérifie si l'utilisateur a la permission de créer un plan
        if (!auth()->user()->can('créer des plans')) {
            throw new UnauthorizedException();
        }

        $programmes = Programme::all();
        return view('plans.create', compact('programmes'));
    }

    public function store(Request $request)
    {
        // Vérifie si l'utilisateur a la permission de créer un plan
        if (!auth()->user()->can('créer des plans')) {
            throw new UnauthorizedException();
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date_format:d/m/Y',
            'end_date' => 'required|date_format:d/m/Y|after_or_equal:start_date',
            'programme_id' => 'required|exists:programmes,id',
        ]);

        // Convertir les dates au format Y-m-d avant d'insérer dans la base de données
        $startDate = Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d');

        Plan::create([
            'programme_id' => $request->programme_id,
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'active',
        ]);

        return redirect()->route('plans.index')->with('success', 'Plan créé avec succès.');
    }

    public function show($id)
    {
        // Vérifie si l'utilisateur a la permission de voir un plan
        if (!auth()->user()->can('voir les plans')) {
            throw new UnauthorizedException();
        }

        $plan = Plan::findOrFail($id);
        $comments = $plan->comments;  // Récupère les commentaires liés au plan

        return view('plans.show', compact('plan', 'comments'));
    }

    public function edit($id)
    {
        // Vérifie si l'utilisateur a la permission de modifier un plan
        if (!auth()->user()->can('modifier les plans')) {
            throw new UnauthorizedException();
        }

        $plan = Plan::find($id);

        if ($plan->start_date) {
            $plan->start_date = \Carbon\Carbon::createFromFormat('Y-m-d', $plan->start_date)->format('d/m/Y');
        }

        if ($plan->end_date) {
            $plan->end_date = \Carbon\Carbon::createFromFormat('Y-m-d', $plan->end_date)->format('d/m/Y');
        }

        return view('plans.edit', compact('plan'));
    }

    public function update(Request $request, $id)
    {
        // Vérifie si l'utilisateur a la permission de modifier un plan
        if (!auth()->user()->can('modifier les plans')) {
            throw new UnauthorizedException();
        }

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'start_date' => 'required|date_format:d/m/Y',
            'end_date' => 'required|date_format:d/m/Y|after_or_equal:start_date',
        ]);

        $plan = Plan::find($id);

        $plan->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d'),
            'end_date' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d'),
        ]);

        return redirect()->route('plans.index')
            ->with('success', 'Plan mis à jour avec succès.');
    }

    public function destroy($id)
    {
        // Vérifie si l'utilisateur a la permission de supprimer un plan
        if (!auth()->user()->can('supprimer les plans')) {
            throw new UnauthorizedException();
        }

        $plan = Plan::find($id);
        $plan->delete();

        return redirect()->route('plans.index')->with('success', 'Plan supprimé avec succès.');
    }

    public function archive($id)
    {
        // Vérifie si l'utilisateur a la permission d'archiver un plan
        if (!auth()->user()->can('Archiver des plans')) {
            throw new UnauthorizedException();
        }

        $plan = Plan::findOrFail($id);

        // Toggle the status between 'active' and 'archived'
        $plan->status = ($plan->status === 'active') ? 'archived' : 'active';
        $plan->save();

        return redirect()->route('plans.index')->with('success', 'Le plan a été mis à jour avec succès.');
    }

    public function unarchive($id)
    {
        // Vérifie si l'utilisateur a la permission de désarchiver un plan
        if (!auth()->user()->can('Archiver des plans')) {
            throw new UnauthorizedException();
        }

        $plan = Plan::find($id);
        $plan->update(['status' => 'active']);

        return redirect()->route('plans.index')
            ->with('success', 'Plan désarchivé avec succès.');
    }

    public function generateReport($id)
    {
        // Vérifie si l'utilisateur a la permission de générer un rapport
        if (!auth()->user()->can('voir les plans')) {
            throw new UnauthorizedException();
        }

        $plan = Plan::with([
            'activities.subactivities.tasks'
        ])->findOrFail($id);

        $data = [
            'planTitle' => $plan->title,
            'planDescription' => $plan->description,
            'startDate' => \Carbon\Carbon::parse($plan->start_date)->format('d/m/Y'),
            'endDate' => \Carbon\Carbon::parse($plan->end_date)->format('d/m/Y'),
            'status' => $plan->status === 'active' ? 'Active' : 'Archivé',
            'activities' => $plan->activities->map(function ($activity) {
                // Calcul du pourcentage de l'activité
                $totalSubactivities = $activity->subactivities->count();
                $totalProgress = $activity->subactivities->sum(function ($subactivity) {
                    $totalTasks = $subactivity->tasks->count();
                    $totalTaskProgress = $subactivity->tasks->sum('progress');
                    return $totalTasks > 0 ? $totalTaskProgress / $totalTasks : 0;
                });
                $activityProgress = $totalSubactivities > 0 ? $totalProgress / $totalSubactivities : 0;

                return [
                    'activityTitle' => $activity->title,
                    'progress' => number_format($activityProgress, 2),
                    'subactivities' => $activity->subactivities->map(function ($subactivity) {
                        // Calcul du pourcentage de la sous-activité
                        $totalTasks = $subactivity->tasks->count();
                        $totalTaskProgress = $subactivity->tasks->sum('progress');
                        $subactivityProgress = $totalTasks > 0 ? $totalTaskProgress / $totalTasks : 0;

                        return [
                            'title' => $subactivity->title,
                            'progress' => number_format($subactivityProgress, 2),
                            'allTasksCompleted' => $subactivity->tasks->every(function ($task) {
                                return $task->progress == 100;
                            }),
                            'tasks' => $subactivity->tasks->map(function ($task) {
                                return [
                                    'title' => $task->title,
                                    'due_date' => $task->due_date,
                                    'progress' => $task->progress,
                                ];
                            }),
                        ];
                    }),
                ];
            }),
        ];

        $pdf = PDF::loadView('reports.plan_report', $data);
        return $pdf->download('rapport_plan_' . $plan->id . '.pdf');
    }

    public function addComment(Request $request, $planId)
    {
        // Vérifie si l'utilisateur a la permission de commenter un plan
        if (!auth()->user()->can('voir les plans')) {
            throw new UnauthorizedException();
        }

        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        // Retrieve the plan to get the associated programme_id
        $plan = Plan::findOrFail($planId);

        // Create a comment and associate it with the programme and plan
        Comment::create([
            'programme_id' => $plan->programme_id,  // Get the programme_id from the plan
            'plan_id' => $planId,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        // Redirect to the plan's page with a success message
        return redirect()->route('plans.show', $planId)->with('success', 'Commentaire ajouté pour le plan.');
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

    public function loadActivities($id)
    {
        $activities = Activity::where('plan_id', $id)->select('id', 'title', 'progress')->get();
        return response()->json($activities);
    }
}