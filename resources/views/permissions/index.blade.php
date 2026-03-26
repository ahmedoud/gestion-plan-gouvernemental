@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestion des Permissions</h1>

    {{-- Bouton pour créer une nouvelle permission --}}
    <a href="{{ route('permissions.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus-circle"></i> Créer une Permission
    </a>

            <!-- Message de succès -->
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

    {{-- Tableau des permissions --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permissions as $permission)
            <tr>
                <td>{{ $permission->id }}</td>
                <td>{{ $permission->name }}</td>
                <td>
                    {{-- Alignement horizontal des boutons --}}
                    <div class="btn-group" role="group">
                        <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $permissions->links('vendor.pagination.bootstrap-4') }} {{-- Vue personnalisée pour la pagination --}}
    </div>
</div>

{{-- Inclure un fichier CSS supplémentaire pour les styles personnalisés --}}
<link rel="stylesheet" href="{{ asset('css/permi.css') }}">

@endsection
