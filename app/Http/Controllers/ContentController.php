<?php

namespace App\Http\Controllers;

use App\Models\Secteur;
use App\Models\Programme;
use App\Models\Plan;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function getContent($id)
    {
        // Trouver le secteur par son ID
        $secteur = Secteur::find($id);

        if (!$secteur) {
            return response()->json(['message' => 'Secteur non trouvé.'], 404);
        }

        // Récupérer les programmes associés au secteur
        $programmes = $secteur->programmes;

        // Vous pouvez ajouter d'autres relations selon votre structure, par exemple les plans
        $plans = Plan::where('secteur_id', $secteur->id)->get();

        // Retourner la vue avec les données récupérées
        return view('content.show', compact('secteur', 'programmes', 'plans'));
    }
}
