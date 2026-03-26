@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le Rôle : {{ $role->name }}</h1>
    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nom du Rôle</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}" required>
        </div>

        <div class="mb-3">
            <label for="permissions" class="form-label">Permissions</label>
            <select name="permissions[]" id="permissions" class="form-control" multiple>
                @foreach ($permissions as $permission)
                <option value="{{ $permission->id }}" @if(in_array($permission->id, $rolePermissions)) selected @endif>
                    {{ $permission->name }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- Bouton similaire à celui de 'permissions/edit.blade.php' --}}
        <button type="submit" class="btn btn-primary mt-3">
            <i class="fas fa-save"></i> Mettre à jour
        </button>
    </form>
</div>
@endsection
