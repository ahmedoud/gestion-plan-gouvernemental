@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Créer une Tâche</h1>
    <form action="{{ route('tasks.store', ['plan' => $planId, 'activity' => $activityId, 'subActivity' => $subActivityId]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="start_date">Date de Début</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="end_date">Date de Fin</label>
            <input type="date" name="end_date" id="end_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="progress">Avancement (%)</label>
            <input type="number" name="progress" id="progress" class="form-control" min="0" max="100" required>
        </div>
        <div class="form-group">
            <label for="budget">Budget</label>
            <input type="number" name="budget" id="budget" class="form-control" step="0.01" min="0" required>
        </div>
        <div class="form-group">
            <label for="users">Utilisateurs</label>
            <select name="users[]" id="users" class="form-control" multiple>
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</div>
@endsection
