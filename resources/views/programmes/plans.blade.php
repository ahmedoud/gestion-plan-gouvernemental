@extends('layouts.app')

@section('title', 'Liste des Plans')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Liste des Plans</h1>
    <a href="{{ route('plans.create') }}" class="btn btn-primary btn-sm mb-3">
        <i class="fas fa-plus"></i> Créer un Nouveau Plan
    </a>

    <table class="table table-bordered table-sm">
        <thead class="bg-primary text-white">
            <tr>
                <th>Titre</th>
                <th>Description</th>
                <th>Date de Début</th>
                <th>Date de Fin</th>
                <th>Status</th>
                <th>Actions</th>
                <th>Activités</th>
                <th>Rapport</th> <!-- Nouvelle colonne Rapport -->
            </tr>
        </thead>
        <tbody>
            @foreach ($plans as $plan)
                <tr>
                    <td>{{ $plan->title }}</td>
                    <td>{{ $plan->description }}</td>
                    <td>{{ $plan->start_date }}</td>
                    <td>{{ $plan->end_date }}</td>
                    <td>
                        <span class="badge {{ $plan->status === 'active' ? 'badge-success' : 'badge-secondary' }}">
                            {{ $plan->status === 'active' ? 'Active' : 'Archived' }}
                        </span>
                    </td>
                    <td class="d-flex align-items-center">

                        <a href="{{ route('plans.edit', $plan->id) }}" class="btn btn-info btn-sm mr-2">
                            <i class="fas fa-edit"></i>Éditer
                        </a>
                        <form action="{{ route('plans.archive', $plan->id) }}" method="POST" class="mr-2" style="display:inline;">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-warning btn-sm">
                                <i class="fas fa-archive"></i> {{ $plan->status === 'active' ? 'Archiver' : 'Désarchiver' }}
                            </button>
                        </form>
                        <form action="{{ route('plans.destroy', $plan->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer ce plan ?');">
                                <i class="fas fa-trash-alt"></i> Supprimer
                            </button>
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('activities.index', $plan->id) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-list"></i> Voir/Créer Activités
                        </a>
                    </td>
                    <td>
                        <!-- Bouton pour télécharger le rapport PDF -->
                        <a href="{{ route('plans.report', $plan->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-file-pdf"></i> Générer le Rapport
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('styles')
<!-- Inclure les styles spécifiques -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    /* Smaller table rows */
    .table th, .table td {
        padding: 5px; /* Réduction du padding */
        font-size: 0.85rem; /* Réduction de la taille de police */
    }

    /* Smaller buttons */
    .btn-sm {
        font-size: 0.75rem;  /* Even smaller button text */
        padding: 3px 8px; /* Further reduce padding */
    }

    /* Smaller icons */
    .fas {
        font-size: 0.85rem; /* Réduction des icônes */
    }

    /* Adjust modal and form padding */
    .modal-body {
        padding: 10px; /* Réduction du padding dans le modal */
    }
    .modal-footer {
        padding: 8px; /* Réduction du padding du footer du modal */
    }

    /* Table with reduced width */
    .table {
        font-size: 0.85rem;
    }

    /* Badge style adjustment */
    .badge {
        font-size: 0.75rem; /* Taille des badges réduite */
    }

    /* Reduce width of buttons */
    .btn i {
        font-size: 0.85rem; /* Réduction de la taille des icônes dans les boutons */
    }
</style>
@endsection

@section('scripts')
<!-- Inclure les scripts spécifiques -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
@endsection
