<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // Appliquer le middleware pour vérifier le rôle 'admin'
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

    // Liste des utilisateurs
    public function index()
    {
        $users = User::with('roles')->paginate(6);
        $roles = Role::all(); // Pour gérer les rôles dans le formulaire
        return view('users.index', compact('users', 'roles'));
    }

    // Formulaire de création d'utilisateur
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    // Stocker un nouvel utilisateur
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'unique:users,email',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/\.gov\.mr$/', $value)) {
                        $fail('Seules les adresses e-mail se terminant par .gov.mr sont autorisées.');
                    }
                },
            ],
            'password' => 'required|string|confirmed|min:8',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        // Création de l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Attribution des rôles
        $user->roles()->sync($request->roles);

        return redirect()->route('users.index')->with('success', 'Utilisateur ajouté avec succès.');
    }

    // Formulaire d'édition
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    // Mise à jour d'un utilisateur
    public function update(Request $request, User $user)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
                function ($attribute, $value, $fail) {
                    if (!preg_match('/\.gov\.mr$/', $value)) {
                        $fail('Seules les adresses e-mail se terminant par .gov.mr sont autorisées.');
                    }
                },
            ],
            'role' => 'required|exists:roles,id', // Validation pour s'assurer que le rôle existe
            'password' => 'nullable|string|confirmed|min:8', // Nouveau mot de passe est optionnel
        ]);

        // Mise à jour des informations de base
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            // Si un nouveau mot de passe est fourni, on le met à jour
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
        ]);

        // Mise à jour des rôles
        $user->roles()->sync([$request->role]);

        // Redirection avec un message de succès
        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    // Suppression d'un utilisateur
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }

    // Afficher les détails d'un utilisateur
    public function show($id)
    {
        $user = User::with([
            'tasks.subActivity.activity.plan.programme.secteur' // Charger toutes les relations nécessaires
        ])->findOrFail($id);

        return view('users.show', compact('user'));
    }
}