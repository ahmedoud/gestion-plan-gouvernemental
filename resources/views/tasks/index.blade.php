@extends('layouts.app')

@section('title', 'Tâches')

@section('content')
    <!-- Lien vers le fichier CSS spécifique pour les Tâches -->
    <!-- <link rel="stylesheet" href="{{ asset('css/tasks.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('css/plans.css') }}">

    <div class="container mt-5">
        <h1>Tâches pour la Sous-Activité: {{ $subActivity->title }}</h1>

        <!-- Bouton pour ajouter une tâche -->
        <a href="{{ route('tasks.create', ['plan' => $planId, 'activity' => $activityId, 'subActivity' => $subActivityId]) }}" class="btn btn-primary btn-sm mb-3">
            <i class="fas fa-plus"></i> Créer une Tâche
        </a>

        <!-- Message de succès -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered table-sm">
            <thead class="bg-primary text-white">
                <tr>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Date de Début</th>
                    <th>Date de Fin</th>
                    <th>Avancement (%)</th>
                    <th>Budget</th>
                    <th>Acteurs</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>
                            <!-- Affichage complet de la description sans la méthode "Voir plus" -->
                            {{ $task->description }}
                        </td>
                        <td>{{ $task->start_date->format('d/m/Y') }}</td>
                        <td>{{ $task->end_date->format('d/m/Y') }}</td>
                        <td>{{ $task->progress }}%</td>
                        <td>{{ $task->budget }} MRU</td>
                        <td>
                            @foreach ($task->users as $user)
                                {{ $user->name }}<br>
                            @endforeach
                        </td>
                        <td class="d-flex align-items-center">
                            <!-- Bouton Voir -->
                            <a href="{{ route('tasks.show', ['plan' => $planId, 'activity' => $activityId, 'subActivity' => $subActivityId, 'task' => $task->id]) }}" class="btn btn-info btn-sm mr-2">
                                <i class="fas fa-eye"></i> Voir
                            </a>
                            <!-- Bouton Modifier -->
                            <a href="{{ route('tasks.edit', ['plan' => $planId, 'activity' => $activityId, 'subActivity' => $subActivityId, 'task' => $task->id]) }}" class="btn btn-warning btn-sm mr-2">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <!-- Formulaire pour supprimer -->
                            <form action="{{ route('tasks.destroy', ['plan' => $planId, 'activity' => $activityId, 'subActivity' => $subActivityId, 'task' => $task->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer cette tâche ?');">
                                    <i class="fas fa-trash-alt"></i> Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection