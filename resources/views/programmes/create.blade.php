@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Créer un Nouveau Programme</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('programmes.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" name="title" class="form-control" id="title" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" id="description" required></textarea>
        </div>

        <div class="form-group">
            <label for="secteur_id">Secteur</label>
            <select name="secteur_id" class="form-control" id="secteur_id" required>
                <option value="">Sélectionner un secteur</option>
                @foreach($secteurs as $secteur)
                    <option value="{{ $secteur->id }}">{{ $secteur->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="start_date">Date de Début</label>
            <input type="text" name="start_date" class="form-control flatpickr" id="start_date" required>
        </div>

        <div class="form-group">
            <label for="end_date">Date de Fin</label>
            <input type="text" name="end_date" class="form-control flatpickr" id="end_date" required>
        </div>

        <!-- Boutons avec espacement -->
        <button type="submit" class="btn btn-primary mt-3 mr-3">Créer</button>
        <a href="{{ route('programmes.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
    </form>
</div>
@endsection

@push('styles')
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr('.flatpickr', {
            dateFormat: "d/m/Y",  // Format de date souhaité
            locale: "fr",         // Optionnel : définit la localisation en français
            altInput: true,       // Ajoute un champ visuel alternatif
            altFormat: "j F, Y",  // Format visuel alternatif plus agréable
            allowInput: true      // Permet à l'utilisateur de taper manuellement
        });
    });
</script>
@endpush