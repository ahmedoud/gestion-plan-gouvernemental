@extends('layouts.app')

@section('title', 'Créer un Nouveau Secteur')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Secteurs.css') }}">

<div class="container mt-5">
    <h1 class="mb-4">Créer un Nouveau Secteur</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('secteurs.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nom">Nom du Secteur</label>
            <input type="text" name="nom" id="nom" class="form-control" placeholder="Nom du Secteur" value="{{ old('nom') }}" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3 mr-3">
            <i class="fas fa-save"></i> Enregistrer
        </button>
        <a href="{{ route('secteurs.index') }}" class="btn btn-secondary mt-3">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </form>
</div>
@endsection
