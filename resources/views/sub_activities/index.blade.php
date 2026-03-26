@extends('layouts.app')

@section('title', 'Sous-Activités')

@section('content')
    <!-- Lien vers le fichier CSS spécifique pour les Sous-Activités -->
    <!-- <link rel="stylesheet" href="{{ asset('css/sub_activities.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('css/plans.css') }}">

    <div class="container mt-5">
        <h1>Sous-Activités pour {{ $activity->title }}</h1>

        <!-- Bouton pour ajouter une nouvelle sous-activité -->
        <a href="{{ route('sub_activities.create', ['plan' => $planId, 'activity' => $activity->id]) }}" class="btn btn-primary btn-sm mb-3">
            <i class="fas fa-plus"></i> Ajouter une Nouvelle Sous-Activité
        </a>

                <!-- Message de succès -->
                @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($subActivities->isEmpty())
            <p>Aucune sous-activité n'est disponible.</p>
        @else
            <table class="table table-bordered table-sm">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Date de Début</th>
                        <th>Date de Fin</th>
                        <th>Avancement (%)</th>
                        <th>Budget (MRU)</th>
                        <th>Tâches</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subActivities as $subActivity)
                        <tr>
                            <td>{{ $subActivity->title }}</td>
                            <td>
                                <!-- Affichage complet de la description sans la méthode "Voir plus" -->
                                {{ $subActivity->description }}
                            </td>
                            <td>{{ $subActivity->start_date ? $subActivity->start_date->format('d/m/Y') : '' }}</td>
                            <td>{{ $subActivity->end_date ? $subActivity->end_date->format('d/m/Y') : '' }}</td>
                            <td>{{ $subActivity->progress }}%</td>
                            <td>{{ $subActivity->budget }}</td>
                            <td>
                                <a href="{{ route('tasks.index', ['plan' => $planId, 'activity' => $activity->id, 'subActivity' => $subActivity->id]) }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-tasks"></i> Voir les Tâches
                                </a>
                            </td>
                            <td class="d-flex align-items-center">
                                <!-- Bouton Voir -->
                                <a href="{{ route('sub_activities.show', ['plan' => $planId, 'activity' => $activity->id, 'subActivity' => $subActivity->id]) }}" class="btn btn-success btn-sm mr-2">
                                    <i class="fas fa-eye"></i> Voir
                                </a>
                                <!-- Bouton pour éditer la sous-activité -->
                                <a href="{{ route('sub_activities.edit', ['plan' => $planId, 'activity' => $activity->id, 'subActivity' => $subActivity->id]) }}" class="btn btn-info btn-sm mr-2">
                                    <i class="fas fa-edit"></i> Éditer
                                </a>

                                <!-- Formulaire pour supprimer la sous-activité -->
                                <form action="{{ route('sub_activities.destroy', ['plan' => $planId, 'activity' => $activity->id, 'subActivity' => $subActivity->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer cette sous-activité ?');">
                                        <i class="fas fa-trash-alt"></i> Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection
