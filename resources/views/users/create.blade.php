@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter un utilisateur</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" required>
            <small class="text-muted">Seules les adresses e-mail se terminant par .gov.mr sont autorisées.</small>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" class="form-control" id="password" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
        </div>

        <div class="form-group">
            <label for="roles">Rôles</label>
            <select name="roles[]" id="roles" class="form-control" multiple required>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ in_array($role->id, old('roles', [])) ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3 mr-3">Ajouter l'utilisateur</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
    </form>
</div>
@endsection