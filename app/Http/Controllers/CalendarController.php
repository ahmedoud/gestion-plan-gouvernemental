<?php

namespace App\Http\Controllers;

use App\Models\Programme;
use App\Models\Plan;
use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Afficher la vue du calendrier.
     */
    public function index()
    {
        return view('calendar.index'); // La vue du calendrier
    }

    /**
     * Charger les événements pour les Programmes et Plans dans FullCalendar.
     */
    public function getAllEvents()
    {
        // Récupérer tous les programmes
        $programmes = Programme::select('id', 'title', 'start_date', 'end_date')->get();

        // Récupérer tous les plans
        $plans = Plan::select('id', 'title', 'start_date', 'end_date')->get();

        // Formater les événements des programmes
        $programmeEvents = $programmes->map(function ($programme) {
            return [
                'id' => $programme->id,
                'title' => $programme->title,
                'start' => $programme->start_date,
                'end' => Carbon::parse($programme->end_date)->addDay()->format('Y-m-d'),
                'color' => '#1C4882', // Couleur pour les programmes
                'url' => route('programmes.show', $programme->id),
            ];
        });

        // Formater les événements des plans
        $planEvents = $plans->map(function ($plan) {
            return [
                'id' => $plan->id,
                'title' => $plan->title,
                'start' => $plan->start_date,
                'end' => Carbon::parse($plan->end_date)->addDay()->format('Y-m-d'),
                'color' => '#28a745', // Couleur pour les plans
                'url' => route('plans.show', $plan->id),
            ];
        });

        // Combiner les deux collections d'événements
        $allEvents = $programmeEvents->merge($planEvents);

        return response()->json($allEvents); // Retourner tous les événements combinés
    }

    /**
     * Afficher les détails d'un programme.
     */
    public function showProgramme($id)
    {
        $programme = Programme::findOrFail($id);
        return view('programmes.show', compact('programme'));
    }

    /**
     * Afficher les détails d'un plan.
     */
    public function showPlan($id)
    {
        $plan = Plan::findOrFail($id);
        return view('plans.show', compact('plan'));
    }
}
