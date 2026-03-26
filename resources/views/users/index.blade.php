@extends('layouts.app')

@section('title', 'Gestion des utilisateurs')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Gestion des utilisateurs</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm mb-3">
        <i class="fas fa-plus"></i> Ajouter un utilisateur
    </a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tableau des utilisateurs -->
    <table class="table table-bordered table-sm mt-3">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</td>
                    <td class="d-flex">
                        <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm mr-1" title="Voir">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm mr-1" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3">
        {{ $users->links('vendor.pagination.bootstrap-4') }}
    </div>

    <!-- Formulaire d'édition -->
    @if(isset($userToEdit))
    <div class="mt-5">
        <h2>Modifier l'utilisateur</h2>
        <form method="POST" action="{{ route('users.update', $userToEdit->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $userToEdit->name) }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $userToEdit->email) }}" required>
            </div>
            <div class="form-group">
                <label for="role">Rôle</label>
                <select class="form-control" id="role" name="role" required>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ $userToEdit->roles->contains($role->id) ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="password">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirmer le nouveau mot de passe</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Mettre à jour</button>
        </form>
    </div>
    @endif
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
