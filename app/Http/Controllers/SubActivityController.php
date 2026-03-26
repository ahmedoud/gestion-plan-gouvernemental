<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\SubActivity;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Exceptions\UnauthorizedException;

class SubActivityController extends Controller
{
    public function __construct()
    {
        // Ajouter un middleware pour vérifier les permissions
        $this->middleware('can:voir les Sous-activities')->only(['index', 'show']);
        $this->middleware('can:créer des Sous-activities')->only(['create', 'store']);
        $this->middleware('can:modifier les Sous-activities')->only(['edit', 'update']);
        $this->middleware('can:supprimer les Sous-activities')->only(['destroy']);
    }

    public function index($planId, $activityId)
    {
        // Vérifie si l'utilisateur a la permission de voir les sous-activités
        if (!auth()->user()->can('voir les Sous-activities')) {
            throw new UnauthorizedException();
        }

        $activity = Activity::where('id', $activityId)->where('plan_id', $planId)->firstOrFail();
        $subActivities = $activity->subActivities;

        return view('sub_activities.index', compact('planId', 'activity', 'subActivities'));
    }

    public function create($planId, $activityId)
    {
        // Vérifie si l'utilisateur a la permission de créer des sous-activités
        if (!auth()->user()->can('créer des Sous-activities')) {
            throw new UnauthorizedException();
        }

        // Récupérer le plan et l'activité en fonction de leurs identifiants
        $plan = Plan::findOrFail($planId);
        $activity = Activity::findOrFail($activityId);

        // Passer le plan et l'activité à la vue
        return view('sub_activities.create', compact('plan', 'activity'));
    }

    public function store(Request $request, $planId, $activityId)
    {
        // Vérifie si l'utilisateur a la permission de créer des sous-activités
        if (!auth()->user()->can('créer des Sous-activities')) {
            throw new UnauthorizedException();
        }

        $activity = Activity::where('id', $activityId)->where('plan_id', $planId)->firstOrFail();
        $activity->subActivities()->create($request->all());

        return redirect()->route('sub_activities.index', ['plan' => $planId, 'activity' => $activityId])
                        ->with('success', 'Sous-activité créée avec succès');
    }

    public function edit($planId, $activityId, $subActivityId)
    {
        // Vérifie si l'utilisateur a la permission de modifier des sous-activités
        if (!auth()->user()->can('modifier les Sous-activities')) {
            throw new UnauthorizedException();
        }

        $subActivity = SubActivity::where('activity_id', $activityId)->findOrFail($subActivityId);
        $activity = Activity::findOrFail($activityId); // Fetch the activity

        return view('sub_activities.edit', compact('planId', 'activityId', 'subActivity', 'activity'));
    }

    public function update(Request $request, $planId, $activityId, $subActivityId)
    {
        // Vérifie si l'utilisateur a la permission de modifier des sous-activités
        if (!auth()->user()->can('modifier les Sous-activities')) {
            throw new UnauthorizedException();
        }

        $subActivity = SubActivity::where('activity_id', $activityId)->findOrFail($subActivityId);
        $subActivity->update($request->all());

        return redirect()->route('sub_activities.index', ['plan' => $planId, 'activity' => $activityId])
                        ->with('success', 'Sous-activité mise à jour avec succès');
    }

    public function destroy($planId, $activityId, $subActivityId)
    {
        // Vérifie si l'utilisateur a la permission de supprimer des sous-activités
        if (!auth()->user()->can('supprimer les Sous-activities')) {
            throw new UnauthorizedException();
        }

        $subActivity = SubActivity::where('activity_id', $activityId)->findOrFail($subActivityId);
        $subActivity->delete();

        return redirect()->route('sub_activities.index', ['plan' => $planId, 'activity' => $activityId])
                        ->with('success', 'Sous-activité supprimée avec succès');
    }

    public function show($planId, $activityId, $subActivityId)
    {
        // Vérifie si l'utilisateur a la permission de voir les sous-activités
        if (!auth()->user()->can('voir les Sous-activities')) {
            throw new UnauthorizedException();
        }

        // Récupérer la sous-activité en fonction de l'ID
        $subActivity = SubActivity::where('activity_id', $activityId)->findOrFail($subActivityId);
        $activity = Activity::findOrFail($activityId); // Récupérer l'activité associée

        return view('sub_activities.show', compact('planId', 'activity', 'subActivity'));
    }

    public function loadTasks($id)
    {
        $tasks = Task::where('sub_activity_id', $id)->select('id', 'title', 'progress')->get();
        return response()->json($tasks);
    }
}