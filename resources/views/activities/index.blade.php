@extends('layouts.app')

@section('title', 'Liste des Activités')

@section('content')
    <!-- Lien vers le fichier CSS spécifique pour les Activités -->
    <!-- <link rel="stylesheet" href="{{ asset('css/Activities.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('css/plans.css') }}">

    <div class="container mt-5">
        <h1 class="mb-4">Liste des Activités pour le Plan: {{ $plan->title }}</h1>

        <a href="{{ route('activities.create', $plan->id) }}" class="btn btn-primary btn-sm mb-3">
            <i class="fas fa-plus"></i> Ajouter une Nouvelle Activité
        </a>

        <!-- Message de succès -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($activities->isEmpty())
            <p>Aucune activité n'est disponible.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Date de Début</th>
                            <th>Date de Fin</th>
                            <th>Avancement (%)</th>
                            <th>Budget (MRU)</th>
                            <th>Sous-Activités</th>
                            <th>Jalons</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activities as $activity)
                            <tr>
                                <td>{{ $activity->title }}</td>
                                <td>{{ $activity->description }}</td>
                                <td>{{ $activity->start_date ? \Carbon\Carbon::parse($activity->start_date)->format('d/m/Y') : '' }}</td>
                                <td>{{ $activity->end_date ? \Carbon\Carbon::parse($activity->end_date)->format('d/m/Y') : '' }}</td>
                                <td>{{ $activity->progress }}%</td>
                                <td>{{ $activity->budget }} MRU</td>
                                <td>
                                    <a href="{{ route('sub_activities.index', ['plan' => $plan->id, 'activity' => $activity->id]) }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-list"></i> Voir les Sous-Activités
                                    </a>
                                </td>
                                <td>
                                    @foreach($activity->milestones as $milestone)
                                        <div>
                                            <strong>{{ $milestone->title }}</strong><br>
                                            <small>{{ $milestone->description }}</small><br>
                                            <small>Due: {{ \Carbon\Carbon::parse($milestone->due_date)->format('d/m/Y') }}</small><br>
                                        </div>
                                    @endforeach
                                </td>
                                <td class="d-flex align-items-center">
                                    <!-- Bouton Voir -->
                                    <a href="{{ route('activities.show', ['plan' => $plan->id, 'activity' => $activity->id]) }}" class="btn btn-success btn-sm mr-2">
                                        <i class="fas fa-eye"></i> Voir
                                    </a>
                                    <!-- Bouton Éditer -->
                                    <a href="{{ route('activities.edit', ['plan' => $plan->id, 'activity' => $activity->id]) }}" class="btn btn-info btn-sm mr-2">
                                        <i class="fas fa-edit"></i> Éditer
                                    </a>
                                    <!-- Bouton Supprimer -->
                                    <form action="{{ route('activities.destroy', ['plan' => $plan->id, 'activity' => $activity->id]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer cette activité ?');">
                                            <i class="fas fa-trash-alt"></i> Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Pagination links -->
    <div class="d-flex justify-content-center mt-3">
        {{ $activities->links('vendor.pagination.bootstrap-4') }}
    </div>
@endsection