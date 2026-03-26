@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Détails de l'Acteur</h1>
    <div class="form-group">
        <label>Nom:</label>
        <p>{{ $actor->name }}</p>
    </div>
    <div class="form-group">
        <label>Rôle:</label>
        <p>{{ $actor->role }}</p>
    </div>
    <div class="form-group">
        <label>Date de Création:</label>
        <p>{{ $actor->created_at->format('d/m/Y H:i') }}</p>
    </div>
    <a href="{{ route('actors.index') }}" class="btn btn-primary">Retour à la liste</a>
</div>
@endsection
