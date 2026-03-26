<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Milestone;
use Illuminate\Http\Request;

class MilestoneController extends Controller
{
    public function store(Request $request, $planId, $activityId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);

        $activity = Activity::findOrFail($activityId);

        $milestone = new Milestone();
        $milestone->title = $request->title;
        $milestone->description = $request->description;
        $milestone->due_date = $request->due_date;
        $milestone->activity_id = $activity->id;

        $milestone->save();

        return redirect()->route('activities.show', [$planId, $activityId])->with('success', 'Jalon ajouté avec succès!');
    }

    public function destroy($planId, $activityId, $milestoneId)
    {
        $milestone = Milestone::findOrFail($milestoneId);
        $milestone->delete();

        return redirect()->route('activities.show', [$planId, $activityId])->with('success', 'Jalon supprimé avec succès!');
    }
}
