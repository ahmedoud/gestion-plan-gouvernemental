@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Ajouter un Nouvel Acteur</h1>

    <!-- Affichage des messages d'erreur -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('actors.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="role">Rôle</label>
            <input type="text" class="form-control" id="role" name="role" required>
        </div>
        <button type="submit" class="btn btn-success">Créer l'Acteur</button>
    </form>
</div>
@endsection
