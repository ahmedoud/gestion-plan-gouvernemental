{{-- resources/views/roles/create.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Créer un rôle</h1>

        <form action="{{ route('roles.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nom du rôle</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="permissions">Permissions</label>
                <select name="permissions[]" id="permissions" class="form-control" multiple>
                    @foreach($permissions as $permission)
                        <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Boutons avec espacement --}}
            <button type="submit" class="btn btn-primary mt-3 mr-3">Créer le rôle</button>
            <a href="{{ route('roles.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
        </form>
    </div>
@endsection