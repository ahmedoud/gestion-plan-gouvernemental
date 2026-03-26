@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestion des Rôles</h1>

    <a href="{{ route('roles.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus-circle"></i> Créer un Rôle
    </a>

            <!-- Message de succès -->
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Permissions</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
            <tr>
                <td>{{ $role->name }}</td>
                <td>{{ $role->permissions->pluck('name')->join(', ') }}</td>
                <td>
                    {{-- Alignement horizontal des boutons --}}
                    <div class="btn-group" role="group">
                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
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
</div>
<!-- Inclure le fichier CSS -->
<link rel="stylesheet" href="{{ asset('css/rolepermission.css') }}">

@endsection
