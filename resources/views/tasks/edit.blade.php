@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier la Tâche</h1>
    <form action="{{ route('tasks.update', ['plan' => $planId, 'activity' => $activityId, 'subActivity' => $subActivityId, 'task' => $task->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $task->title) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="start_date">Date de Début</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', $task->start_date->format('Y-m-d')) }}" required>
        </div>

        <div class="form-group">
            <label for="end_date">Date de Fin</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', $task->end_date->format('Y-m-d')) }}" required>
        </div>

        <div class="form-group">
            <label for="progress">Avancement (%)</label>
            <input type="number" name="progress" id="progress" class="form-control" value="{{ old('progress', $task->progress) }}" min="0" max="100" required>
        </div>

        <div class="form-group">
            <label for="budget">Budget</label>
            <input type="number" name="budget" id="budget" class="form-control" value="{{ old('budget', $task->budget) }}" step="0.01" min="0" required>
        </div>

        <!-- Afficher la section des utilisateurs assignés uniquement pour l'admin -->
        @if (Auth::user()->hasRole('admin'))
            <div class="form-group">
                <label for="users">Utilisateurs Assignés</label>
                <select name="users[]" id="users" class="form-control" multiple>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $task->users->contains($user->id) ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        <button type="submit" class="btn btn-primary">Mettre à Jour</button>
    </form>
</div>
@endsection