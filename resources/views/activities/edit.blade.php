@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Éditer l'Activité</h1>
    <form action="{{ route('activities.update', [$plan->id, $activity->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Champs pour l'activité -->
        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $activity->title }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description">{{ $activity->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="start_date">Date de Début</label>
            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $activity->start_date ? $activity->start_date->format('Y-m-d') : '' }}" required>
        </div>
        <div class="form-group">
            <label for="end_date">Date de Fin</label>
            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $activity->end_date ? $activity->end_date->format('Y-m-d') : '' }}" required>
        </div>
        <div class="form-group">
            <label for="progress">Avancement (%)</label>
            <input type="number" step="0.01" class="form-control" id="progress" name="progress" value="{{ $activity->progress }}" min="0" max="100">
        </div>
        <div class="form-group">
            <label for="budget">Budget (MRU)</label>
            <input type="number" step="0.01" class="form-control" id="budget" name="budget" value="{{ $activity->budget }}">
        </div>

        <!-- Section pour les jalons -->
        <div class="form-group">
            <label for="milestones">Jalons</label>
            <div id="milestones-container">
                @foreach ($activity->milestones as $i => $milestone)
                    <div class="milestone mt-3">
                        <input type="hidden" name="milestones[{{ $i }}][id]" value="{{ $milestone->id }}">
                        <input type="text"
                               class="form-control mb-2"
                               name="milestones[{{ $i }}][title]"
                               placeholder="Titre du jalon"
                               value="{{ $milestone->title }}"
                               required>
                        <textarea class="form-control mb-2"
                                  name="milestones[{{ $i }}][description]"
                                  placeholder="Description du jalon">{{ $milestone->description }}</textarea>
                        <input type="date"
                               class="form-control mb-2"
                               name="milestones[{{ $i }}][due_date]"
                               value="{{ $milestone->due_date instanceof \Carbon\Carbon ? $milestone->due_date->format('Y-m-d') : $milestone->due_date }}"
                               required>
                    </div>
                @endforeach
            </div>
            <button type="button" id="add-milestone" class="btn btn-secondary mt-3">Ajouter un Jalon</button>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à Jour</button>
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
            <input type="date" class="form-control mb-2" name="milestones[${index}][due_date]" required>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', milestoneHTML);
});
</script>
@endsection
