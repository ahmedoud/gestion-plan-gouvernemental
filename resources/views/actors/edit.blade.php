@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Éditer Acteur</h1>
    <form action="{{ route('actors.update', $actor->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $actor->name }}" required>
        </div>
        <div class="form-group">
            <label for="role">Rôle</label>
            <input type="text" class="form-control" id="role" name="role" value="{{ $actor->role }}" required>
        </div>
        <button type="submit" class="btn btn-warning">Mettre à jour</button>
    </form>
</div>
@endsection
