@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier la Permission</h1>

    <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nom de la permission</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $permission->name) }}" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">
            <i class="fas fa-save"></i> Sauvegarder
        </button>
    </form>
</div>
@endsection
