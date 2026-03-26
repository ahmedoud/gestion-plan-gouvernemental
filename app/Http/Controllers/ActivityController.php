<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Plan;
use App\Models\Milestone;
use Illuminate\Http\Request;
use App\Models\SubActivity;
use App\Models\Task;
use App\Exceptions\UnauthorizedException;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Assurez-vous que l'utilisateur est authentifié
    }

    public function index($planId)
    {
        // Vérifie si l'utilisateur a la permission de voir les activités
        if (!auth()->user()->can('voir les activities')) {
            throw new UnauthorizedException();
        }

        $plan = Plan::findOrFail($planId);
        $activities = $plan->activities()->paginate(2); // Ajout de la pagination ici
        return view('activities.index', compact('plan', 'activities'));
    }

    public function create($planId)
    {
        // Vérifie si l'utilisateur a la permission de créer des activités
        if (!auth()->user()->can('créer des activities')) {
            throw new UnauthorizedException();
        }

        $plan = Plan::findOrFail($planId);
        return view('activities.create', compact('plan'));
    }

    public function store(Request $request, $planId)
    {
        // Vérifie si l'utilisateur a la permission de créer des activités
        if (!auth()->user()->can('créer des activities')) {
            throw new UnauthorizedException();
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'progress' => 'nullable|numeric|min:0|max:100',
            'budget' => 'nullable|numeric|min:0',
            'milestones.*.title' => 'required|string|max:255',
            'milestones.*.due_date' => 'required|date|after_or_equal:start_date',
        ]);

        $plan = Plan::findOrFail($planId);

        $activity = $plan->activities()->create($request->only([
            'title', 'description', 'start_date', 'end_date', 'progress', 'budget'
        ]));

        if ($request->has('milestones')) {
            foreach ($request->input('milestones') as $milestone) {
                $activity->milestones()->create($milestone);
            }
        }

        return redirect()->route('activities.index', $planId)->with('success', 'Activité créée avec succès.');
    }

    public function edit($planId, $id)
    {
        // Vérifie si l'utilisateur a la permission de modifier des activités
        if (!auth()->user()->can('modifier les activities')) {
            throw new UnauthorizedException();
        }

        $plan = Plan::findOrFail($planId);
        $activity = $plan->activities()->findOrFail($id);
        return view('activities.edit', compact('plan', 'activity'));
    }

    public function update(Request $request, $planId, $id)
    {
        // Vérifie si l'utilisateur a la permission de modifier des activités
        if (!auth()->user()->can('modifier les activities')) {
            throw new UnauthorizedException();
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'progress' => 'nullable|numeric|min:0|max:100',
            'budget' => 'nullable|numeric|min:0',
            'milestones.*.title' => 'required|string|max:255',
            'milestones.*.due_date' => 'required|date|after_or_equal:start_date',
        ]);

        $plan = Plan::findOrFail($planId);
        $activity = $plan->activities()->findOrFail($id);

        $activity->update($request->only(['title', 'description', 'start_date', 'end_date', 'progress', 'budget']));

        $milestones = $request->input('milestones', []);
        $existingIds = collect($milestones)->pluck('id')->filter()->toArray();

        $activity->milestones()->whereNotIn('id', $existingIds)->delete();

        foreach ($milestones as $milestoneData) {
            if (isset($milestoneData['id'])) {
                $milestone = Milestone::findOrFail($milestoneData['id']);
                $milestone->update($milestoneData);
            } else {
                $activity->milestones()->create($milestoneData);
            }
        }

        return redirect()->route('activities.index', $planId)->with('success', 'Activité mise à jour avec succès.');
    }

    public function destroy($planId, $id)
    {
        // Vérifie si l'utilisateur a la permission de supprimer des activités
        if (!auth()->user()->can('supprimer les activities')) {
            throw new UnauthorizedException();
        }

        $plan = Plan::findOrFail($planId);
        $activity = $plan->activities()->findOrFail($id);
        $activity->milestones()->delete();
        $activity->delete();

        return redirect()->route('activities.index', $planId)->with('success', 'Activité supprimée avec succès.');
    }

    public function show($planId, $activityId)
    {
        // Vérifie si l'utilisateur a la permission de voir une activité
        if (!auth()->user()->can('voir les activities')) {
            throw new UnauthorizedException();
        }

        $plan = Plan::findOrFail($planId);
        $activity = Activity::where('id', $activityId)->where('plan_id', $planId)->firstOrFail();

        return view('activities.show', compact('plan', 'activity'));
    }

    public function loadSubActivities($id)
    {
        $subActivities = SubActivity::where('activity_id', $id)->select('id', 'title', 'progress')->get();
        return response()->json($subActivities);
    }
}