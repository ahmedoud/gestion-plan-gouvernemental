@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Créer un Plan</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('plans.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="programme_id">Programme</label>
            <select name="programme_id" id="programme_id" class="form-control" required>
                <option value="">Sélectionner un programme</option>
                @foreach($programmes as $programme)
                    <option value="{{ $programme->id }}">{{ $programme->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="start_date">Date de Début</label>
            <input type="text" name="start_date" id="start_date" class="form-control flatpickr" placeholder="jj/mm/aaaa" required>
        </div>

        <div class="form-group">
            <label for="end_date">Date de Fin</label>
            <input type="text" name="end_date" id="end_date" class="form-control flatpickr" placeholder="jj/mm/aaaa" required>
        </div>

        <!-- Boutons avec espacement -->
        <button type="submit" class="btn btn-primary mt-3 mr-3">Créer le Plan</button>
        <a href="{{ route('plans.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
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
        flatpickr(".flatpickr", {
            dateFormat: "d/m/Y",    // Format de la date
            altInput: true,         // Champ alternatif visuel
            altFormat: "j F, Y",    // Format visuel agréable
            allowInput: false,      // Désactive la saisie manuelle
            minDate: "today"        // Empêche la sélection de dates antérieures
        });
    });
</script>
@endpush