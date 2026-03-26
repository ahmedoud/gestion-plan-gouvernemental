<?php

namespace App\Http\Controllers;
use App\Models\Actor; // Assurez-vous que ce chemin est correct
use Illuminate\Http\Request;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actors = Actor::all();
        return view('actors.index', compact('actors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('actors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
        ]);

        Actor::create($request->all());

        return redirect()->route('actors.index')
                        ->with('success', 'Actor created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $actor = Actor::findOrFail($id);
        return view('actors.show', compact('actor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $actor = Actor::findOrFail($id);
        return view('actors.edit', compact('actor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
        ]);

        $actor = Actor::findOrFail($id);
        $actor->update($request->all());

        return redirect()->route('actors.index')
                        ->with('success', 'Acteur mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $actor = Actor::findOrFail($id);
        $actor->delete();

        return redirect()->route('actors.index')
                        ->with('success', 'Acteur supprimé avec succès.');
    }
}
