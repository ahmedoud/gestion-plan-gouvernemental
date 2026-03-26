@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Ajouter une Nouvelle Sous-Activité</h1>
    <!-- Bouton pour voir les sous-activités, avec les deux paramètres requis -->
    <a href="{{ route('sub_activities.index', ['plan' => $plan->id, 'activity' => $activity->id]) }}" class="btn btn-primary mb-3">Voir les Sous-Activités</a>

    <!-- Formulaire de création d'une sous-activité -->
    <form action="{{ route('sub_activities.store', ['plan' => $plan->id, 'activity' => $activity->id]) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" name="title" class="form-control" id="title" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="description" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Date de Début</label>
            <input type="date" name="start_date" class="form-control" id="start_date" required>
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">Date de Fin</label>
            <input type="date" name="end_date" class="form-control" id="end_date" required>
        </div>
        <div class="mb-3">
            <label for="progress" class="form-label">Avancement (%)</label>
            <input type="number" name="progress" class="form-control" id="progress" required>
        </div>
        <div class="mb-3">
            <label for="budget" class="form-label">Budget (MRU)</label>
            <input type="number" name="budget" class="form-control" id="budget" required>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
