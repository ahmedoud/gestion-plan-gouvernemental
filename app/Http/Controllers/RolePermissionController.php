<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    // Vérifie si l'utilisateur a le rôle 'admin' avant chaque méthode
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user() || !auth()->user()->hasRole('admin')) {
                // Rediriger vers une vue d'erreur 403
                return response()->view('errors.access_denied', [], 403);
            }
            return $next($request);
        });
    }


    // Liste des rôles et permissions
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('roles.index', compact('roles'));
    }

    // Formulaire pour créer un rôle
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    // Stocker un nouveau rôle
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create(['name' => $request->name]);
        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Rôle créé avec succès.');
    }

    // Formulaire pour modifier un rôle
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    // Mettre à jour un rôle
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update(['name' => $request->name]);
        $role->permissions()->sync($request->permissions);

        return redirect()->route('roles.index')->with('success', 'Rôle mis à jour avec succès.');
    }

    // Supprimer un rôle
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rôle supprimé avec succès.');
    }

    // Liste des permissions
    public function permissions()
    {
        $permissions = Permission::all();
        $roles = Role::all();
        return view('permissions.index', compact('permissions', 'roles'));
    }

    // Attribuer des permissions à un rôle
    public function assignPermissions(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::findOrFail($request->role_id);
        $role->permissions()->sync($request->permissions);

        return redirect()->route('permissions.index')->with('success', 'Permissions attribuées avec succès.');
    }
}
