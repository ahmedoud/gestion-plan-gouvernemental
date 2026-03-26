@extends('layouts.app')

@section('title', 'Gestion des Secteurs')

@section('content')
<!-- <link rel="stylesheet" href="{{ asset('css/Secteurs.css') }}"> -->
<link rel="stylesheet" href="{{ asset('css/plans.css') }}">
<div class="container mt-5">
    <h1 class="mb-4">Secteurs</h1>
    <a href="{{ route('secteurs.create') }}" class="btn btn-primary btn-sm mb-3">
        <i class="fas fa-plus"></i> Créer un Nouveau Secteur
    </a>

    <!-- Message de succès -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table des secteurs -->
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Programme</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($secteurs as $secteur)
                <tr>
                    <td>{{ $secteur->id }}</td>
                    <td>{{ $secteur->nom }}</td>
                    <td>
                        <a href="{{ route('secteurs.programmes', ['secteur' => $secteur->id]) }}" class="btn btn-success btn-sm" title="Voir les Programmes">
                            <i class="fas fa-eye"></i> Voir les Programmes
                        </a>
                    </td>
                    <td class="d-flex">
                        <a href="{{ route('secteurs.edit', $secteur->id) }}" class="btn btn-info btn-sm mr-2" title="Éditer">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('secteurs.destroy', $secteur->id) }}" method="POST" class="d-inline" title="Supprimer">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer ce secteur ?');">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                        <a href="{{ route('secteurs.show', $secteur->id) }}" class="btn btn-primary btn-sm ml-2" title="Voir le Secteur">
                            <i class="fas fa-eye"></i> Voir
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination links -->
    <div class="d-flex justify-content-center mt-3">
        {{ $secteurs->links('vendor.pagination.bootstrap-4') }} <!-- Custom pagination view -->
    </div>
</div>

<!-- Modal pour ajouter un nouveau secteur -->
<div class="modal fade" id="addSecteurModal" tabindex="-1" role="dialog" aria-labelledby="addSecteurModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSecteurModalLabel">Ajouter un Secteur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="secteurForm" method="POST" action="{{ route('secteurs.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Créer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
