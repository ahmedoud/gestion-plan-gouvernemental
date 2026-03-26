@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails de la Tâche</h1>
    <div class="card">
        <div class="card-header" style="background-color: #007bff; color: white; padding: 12px 8px;">
            Tâche: {{ $task->title }}
        </div>
        <div class="card-body" >
            <p><strong>Description:</strong> {{ $task->description }}</p>
            <p><strong>Date de Début:</strong> {{ $task->start_date->format('d/m/Y') }}</p>
            <p><strong>Date de Fin:</strong> {{ $task->end_date->format('d/m/Y') }}</p>
            <p><strong>Avancement (%):</strong> {{ $task->progress }}%</p>
            <p><strong>Budget:</strong> {{ $task->budget }} MRU</p>
            <p><strong>Utilisateurs:</strong></p>
            <ul>
                @foreach ($task->users as $user)
                    <li>{{ $user->name }}</li>
                @endforeach
            </ul>
            <a href="{{ route('tasks.index', ['plan' => $planId, 'activity' => $activityId, 'subActivity' => $subActivityId]) }}" class="btn btn-primary">Retour à la Liste des Tâches</a>
        </div>
    </div>
</div>
@endsection
