<?php

namespace App\Http\Controllers;

use App\Models\Plan;

class ReportController extends Controller
{
    // Fonction pour afficher la liste des plans
    public function showPlans()
    {
        // Récupérer tous les plans
        $plans = Plan::all();

        // Passer les plans à la vue
        return view('reports.index', compact('plans'));
    }

    // Fonction pour générer le rapport PDF
    public function generateReport($planId)
    {
        // Récupérer les données du plan avec les activités et jalons
        $plan = Plan::with(['activities', 'activities.milestones'])->find($planId);

        // Vérifie si le plan existe
        if (!$plan) {
            return redirect()->back()->with('error', 'Plan introuvable');
        }

        // Formater les données pour la vue
        $reportData = [
            'planTitle' => $plan->title,
            'activities' => $plan->activities->map(function($activity) {
                return [
                    'activityTitle' => $activity->title,
                    'progress' => $activity->progress,
                    'milestones' => $activity->milestones,
                ];
            }),
        ];

        // Générer le PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.plan_report', $reportData);

        // Télécharger le PDF
        return $pdf->download('rapport_plan_' . $plan->title . '.pdf');
    }
}
