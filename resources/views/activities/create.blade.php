@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Ajouter une Nouvelle Activité</h1>
    <form action="{{ route('activities.store', $plan->id) }}" method="POST">
        @csrf
        <!-- Champs pour les informations de l'activité -->
        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <div class="form-group">
            <label for="start_date">Date de Début</label>
            <input type="date" class="form-control" id="start_date" name="start_date" required>
        </div>
        <div class="form-group">
            <label for="end_date">Date de Fin</label>
            <input type="date" class="form-control" id="end_date" name="end_date" required>
        </div>
        <div class="form-group">
            <label for="progress">Avancement (%)</label>
            <input type="number" step="0.01" class="form-control" id="progress" name="progress" value="0.00" min="0" max="100">
        </div>
        <div class="form-group">
            <label for="budget">Budget (MRU)</label>
            <input type="number" step="0.01" class="form-control" id="budget" name="budget">
        </div>

        <!-- Section pour les jalons -->
        <div class="form-group">
            <label for="milestones">Jalons</label>
            <div id="milestones-container">
                <div class="milestone">
                    <input type="text" class="form-control mb-2" name="milestones[0][title]" placeholder="Titre du jalon" required>
                    <textarea class="form-control mb-2" name="milestones[0][description]" placeholder="Description du jalon"></textarea>
                    <input type="date" class="form-control mb-2" name="milestones[0][due_date]" placeholder="Date d'échéance" required>
                </div>
            </div>
            <!-- <button type="button" class="btn btn-link" id="add-milestone">Ajouter un Jalon</button> -->
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer l'Activité</button>
    </form>
</div>

<script>
    document.getElementById('add-milestone').addEventListener('click', function() {
        let container = document.getElementById('milestones-container');
        let index = container.children.length;

        let milestoneHTML = `
            <div class="milestone mt-3">
                <input type="text" class="form-control mb-2" name="milestones[${index}][title]" placeholder="Titre du jalon" required>
                <textarea class="form-control mb-2" name="milestones[${index}][description]" placeholder="Description du jalon"></textarea>
                <input type="date" class="form-control mb-2" name="milestones[${index}][due_date]" placeholder="Date d'échéance" required>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', milestoneHTML);
    });
</script>
@endsection
