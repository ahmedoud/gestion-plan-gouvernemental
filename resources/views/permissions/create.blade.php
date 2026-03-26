{{-- resources/views/permissions/create.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Créer une Permission</h1>

        <form action="{{ route('permissions.store') }}" method="POST">
            @csrf

            {{-- Nom de la permission --}}
            <div class="form-group">
                <label for="name">Nom de la permission</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Exemple: gérer les utilisateurs" required>
            </div>

            {{-- Boutons avec espacement --}}
            <button type="submit" class="btn btn-primary mt-3 mr-3">Créer la permission</button>
            <a href="{{ route('permissions.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
        </form>
    </div>
@endsection