<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\SubActivity;
use Illuminate\Http\Request;
use App\Models\User;
//use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\UnauthorizedException;

class TaskManagerController extends Controller
{
    public function __construct()
    {
        // Ajouter des middleware pour vérifier les permissions de chaque action
        $this->middleware('can:voir les tasks')->only(['index', 'show']);
        $this->middleware('can:créer des tasks')->only(['create', 'store']);
        $this->middleware('can:modifier les tasks')->only(['edit', 'update']);
        $this->middleware('can:supprimer les tasks')->only(['destroy']);
    }

    // Méthode pour vérifier les échéances et envoyer des notifications
    public function checkDeadlines()
    {
        $user = Auth::user();
        $notifications = [];

        // Récupérer les tâches assignées à l'utilisateur
        $tasks = $user->tasks()->where('end_date', '>=', Carbon::now())
            ->where('end_date', '<=', Carbon::now()->addDays(3))
            ->get();

        foreach ($tasks as $task) {
            $notifications[] = [
                'message' => "La tâche '{$task->title}' arrive à échéance le {$task->end_date->format('d/m/Y')}.",
                'url' => route('tasks.show', [
                    'plan' => $task->subActivity->activity->plan->id,
                    'activity' => $task->subActivity->activity->id,
                    'subActivity' => $task->subActivity->id,
                    'task' => $task->id,
                ]),
            ];
        }

        return $notifications;
    }

    public function index($plan, $activity, $subActivity)
    {
        // Vérifie si l'utilisateur a la permission de voir les tâches
        if (!auth()->user()->can('voir les tasks')) {
            throw new UnauthorizedException();
        }

        $subActivity = SubActivity::findOrFail($subActivity);
        $tasks = Task::where('sub_activity_id', $subActivity->id)->get();

        return view('tasks.index', [
            'subActivity' => $subActivity,
            'tasks' => $tasks,
            'planId' => $plan,
            'activityId' => $activity,
            'subActivityId' => $subActivity->id,
        ]);
    }

    public function create($planId, $activityId, $subActivityId)
    {
        // Vérifie si l'utilisateur a la permission de créer des tâches
        if (!auth()->user()->can('créer des tasks')) {
            throw new UnauthorizedException();
        }

        $subActivity = SubActivity::findOrFail($subActivityId);
        $users = User::all(); // Charger les utilisateurs
        return view('tasks.create', compact('subActivity', 'users', 'planId', 'activityId', 'subActivityId'));
    }

    public function store(Request $request, $planId, $activityId, $subActivityId)
    {
        // Vérifie si l'utilisateur a la permission de créer des tâches
        if (!auth()->user()->can('créer des tasks')) {
            throw new UnauthorizedException();
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'progress' => 'required|numeric',
            'budget' => 'nullable|numeric',
        ]);

        $task = Task::create([
            'sub_activity_id' => $subActivityId,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'progress' => $validated['progress'],
            'budget' => $validated['budget'] ?? 0,
        ]);

        // Synchroniser les utilisateurs assignés (uniquement pour l'admin)
        if (Auth::user()->hasRole('admin') && $request->has('users')) {
            $task->users()->sync($request->input('users'));
        }

        $this->updateSubActivityAndActivityProgress($subActivityId);

        // // Création de l'événement lié
        // Event::create([
        //     'title' => "Échéance: {$task->title}",
        //     'description' => $task->description,
        //     'start_date' => $task->due_date,
        //     'type' => 'Task',
        //     'related_id' => $task->id,
        // ]);

        // Message de succès
        return redirect()->route('tasks.index', [
            'plan' => $planId,
            'activity' => $activityId,
            'subActivity' => $subActivityId,
        ])->with('success', 'Tâche créée avec succès.');
    }

    public function edit($plan, $activity, $subActivity, $taskId)
    {
        // Vérifie si l'utilisateur a la permission de modifier des tâches
        if (!auth()->user()->can('modifier les tasks')) {
            throw new UnauthorizedException();
        }

        $task = Task::findOrFail($taskId);
        $users = User::all(); // Charger les utilisateurs

        // Vérifier si l'utilisateur est un acteur de la tâche ou un admin/responsable
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->hasRole('responsable') && !$task->users->contains($user)) {
            throw new UnauthorizedException();
        }

        return view('tasks.edit', [
            'task' => $task,
            'planId' => $plan,
            'activityId' => $activity,
            'subActivityId' => $subActivity,
            'users' => $users, // Passer les utilisateurs ici
        ]);
    }

    public function update(Request $request, $plan, $activity, $subActivity, $taskId)
    {
        // Vérifie si l'utilisateur a la permission de modifier des tâches
        if (!auth()->user()->can('modifier les tasks')) {
            throw new UnauthorizedException();
        }

        $task = Task::findOrFail($taskId);
        $user = Auth::user();

        // Vérifier si l'utilisateur est un acteur de la tâche ou un admin/responsable
        if (!$user->hasRole('admin') && !$user->hasRole('responsable') && !$task->users->contains($user)) {
            throw new UnauthorizedException();
        }

        // Validation des champs
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'progress' => 'required|integer|min:0|max:100',
            'budget' => 'nullable|numeric',
        ]);

        // Si l'utilisateur est un utilisateur simple, il ne peut modifier que l'avancement
        if ($user->hasRole('utilisateur_simple')) {
            $task->update([
                'progress' => $request->input('progress'),
            ]);
        } else {
            // Sinon, mettre à jour tous les champs
            $task->update($request->only(['title', 'description', 'start_date', 'end_date', 'progress', 'budget']));

            // Synchroniser les utilisateurs assignés (uniquement pour l'admin)
            if ($user->hasRole('admin') && $request->has('users')) {
                $task->users()->sync($request->input('users'));
            }
        }

        $this->updateSubActivityAndActivityProgress($subActivity);

        // Message de succès
        return redirect()->route('tasks.index', [
            'plan' => $plan,
            'activity' => $activity,
            'subActivity' => $subActivity
        ])->with('success', 'Tâche mise à jour avec succès.');
    }

    public function destroy($plan, $activity, $subActivity, $taskId)
    {
        // Vérifie si l'utilisateur a la permission de supprimer des tâches
        if (!auth()->user()->can('supprimer les tasks')) {
            throw new UnauthorizedException();
        }

        $task = Task::findOrFail($taskId);

        // Vérifier si l'utilisateur est un admin ou responsable
        $user = Auth::user();
        if (!$user->hasRole('admin') && !$user->hasRole('responsable')) {
            throw new UnauthorizedException();
        }

        $task->delete();

        $this->updateSubActivityAndActivityProgress($subActivity);

        // Message de succès
        return redirect()->route('tasks.index', [
            'plan' => $plan,
            'activity' => $activity,
            'subActivity' => $subActivity
        ])->with('success', 'Tâche supprimée avec succès.');
    }

    public function show($plan, $activity, $subActivity, $taskId)
    {
        // Vérifie si l'utilisateur a la permission de voir les tâches
        if (!auth()->user()->can('voir les tasks')) {
            throw new UnauthorizedException();
        }

        $task = Task::findOrFail($taskId);
        return view('tasks.show', [
            'task' => $task,
            'planId' => $plan,
            'activityId' => $activity,
            'subActivityId' => $subActivity
        ]);
    }

    private function updateSubActivityAndActivityProgress($subActivityId)
    {
        $subActivity = SubActivity::findOrFail($subActivityId);
        $subActivity->updateProgress();
        $subActivity->activity->updateProgress();
    }
}