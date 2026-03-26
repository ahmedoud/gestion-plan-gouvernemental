<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    // Vérifie si l'utilisateur a le rôle 'admin' avant chaque méthode
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user() || !auth()->user()->hasRole('admin')) {
                // Redirige vers une vue d'erreur 403 si l'utilisateur n'est pas admin
                return response()->view('errors.access_denied', [], 403);
            }
            return $next($request);
        });
    }

    // Afficher le formulaire de création
    public function create()
    {
        return view('permissions.create');
    }

    // Stocker une nouvelle permission
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create(['name' => $request->name]);

        return redirect()->route('permissions.index')->with('success', 'Permission créée avec succès.');
    }

    // Afficher la liste des permissions avec pagination
    public function index()
    {
        // Paginer les permissions
        $permissions = Permission::paginate(5); // Modifier '10' selon vos besoins
        return view('permissions.index', compact('permissions'));
    }

    // Afficher le formulaire d'édition d'une permission
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('permissions.edit', compact('permission'));
    }

    // Mettre à jour une permission
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $id,
        ]);

        $permission = Permission::findOrFail($id);
        $permission->update(['name' => $request->name]);

        return redirect()->route('permissions.index')->with('success', 'Permission mise à jour avec succès.');
    }

    // Supprimer une permission
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route('permissions.index')->with('success', 'Permission supprimée avec succès.');
    }
}
