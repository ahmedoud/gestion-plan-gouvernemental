@extends('layouts.app')

@section('title', 'Liste des Programmes')

@section('content')
<link rel="stylesheet" href="{{ asset('css/programmes.css') }}">
<div class="container mt-5">
    <h1 class="mb-4">Liste des Programmes</h1>
    <a href="{{ route('programmes.create') }}" class="btn btn-primary btn-sm mb-3">
        <i class="fas fa-plus"></i> Créer un Nouveau Programme
    </a>

    <!-- Message de succès -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table des programmes -->
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Secteur</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Actions</th>
                <th>Plans</th>
                <th>Rapport</th> <!-- Ajout de la colonne Rapport -->
            </tr>
        </thead>
        <tbody>
            @foreach ($programmes as $programme)
                <tr>
                    <td>{{ $programme->title }}</td>
                    <td>
                        <div class="description" id="desc-{{ $programme->id }}">{{ $programme->description }}</div>
                        @if(strlen($programme->description) > 50)
                            <span class="show-more" onclick="toggleDescription({{ $programme->id }})">Voir tout</span>
                        @endif
                    </td>
                    <td>{{ $programme->secteur ? $programme->secteur->nom : 'N/A' }}</td>
                    <td>{{ $programme->start_date }}</td>
                    <td>{{ $programme->end_date }}</td>
                    <td>
                        <span class="badge {{ $programme->status === 'active' ? 'badge-success' : 'badge-secondary' }}">
                            {{ $programme->status === 'active' ? 'Active' : 'Archived' }}
                        </span>
                    </td>
                    <td class="d-flex align-items-center">
                        <a href="{{ route('programmes.edit', $programme->id) }}" class="btn btn-info btn-sm mr-2">
                            <i class="fas fa-edit"></i> Éditer
                        </a>
                        <form action="{{ route('programmes.archive', $programme->id) }}" method="POST" class="mr-2" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm">
                                <i class="fas fa-folder-open"></i> {{ $programme->status === 'active' ? 'Archiver' : 'Désarchiver' }}
                            </button>
                        </form>
                        <form action="{{ route('programmes.destroy', $programme->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i> Supprimer
                            </button>
                        </form>

                        <!-- Bouton Voir (Afficher les détails) -->
                        <a href="{{ route('programmes.show', $programme->id) }}" class="btn btn-success btn-sm ml-2">
                            <i class="fas fa-eye"></i> Voir
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('programmes.plans', ['programme' => $programme->id]) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-list"></i> Afficher les listes des plans
                        </a>
                    </td>
                    <td>
                        <!-- Bouton pour télécharger le rapport PDF -->
                        <a href="{{ route('programmes.report', $programme->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-file-pdf"></i> Générer le Rapport
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
    function toggleDescription(id) {
        const descElement = document.getElementById(`desc-${id}`);
        if (descElement.classList.contains('description')) {
            descElement.classList.remove('description');
            descElement.nextElementSibling.innerText = 'Voir moins';
        } else {
            descElement.classList.add('description');
            descElement.nextElementSibling.innerText = 'Voir tout';
        }
    }
</script>
@endsection