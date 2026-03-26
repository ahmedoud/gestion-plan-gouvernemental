<?php

namespace App\Http\Controllers;

use App\Models\Secteur;
use App\Models\Programme;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $secteurs = Secteur::all();  // Fetch all sectors
        $programmes = Programme::all(); // Fetch all programmes
        $usersCount = User::count(); // Count of users
        $secteursCount = Secteur::count(); // Count of sectors
        $programmesCount = Programme::count(); // Count of programmes

        // Pass the variables to the view
        return view('admin.dashboard', [
            'secteurs' => $secteurs,
            'programmes' => $programmes,
            'usersCount' => $usersCount,
            'secteursCount' => $secteursCount,
            'programmesCount' => $programmesCount,
        ]);
    }
}
