@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier l'utilisateur</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            <small class="text-muted">Seules les adresses e-mail se terminant par .gov.mr sont autorisées.</small>
        </div>

        <div class="form-group">
            <label for="role">Rôle</label>
            <select class="form-control" id="role" name="role" required>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ $user->roles->contains('id', $role->id) ? 'selected' : '' }}>
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

        <button type="submit" class="btn btn-primary mt-3 mr-3">Mettre à jour</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
    </form>
</div>
@endsection