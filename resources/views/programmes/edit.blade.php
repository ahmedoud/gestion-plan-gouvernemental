@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Modifier le Programme</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('programmes.update', $programme->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Titre</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ $programme->title }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" id="description" required>{{ $programme->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="secteur_id">Secteur</label>
            <select name="secteur_id" class="form-control" id="secteur_id" required>
                @foreach($secteurs as $secteur)
                    <option value="{{ $secteur->id }}" {{ $programme->secteur_id == $secteur->id ? 'selected' : '' }}>
                        {{ $secteur->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="start_date">Date de Début</label>
            <input type="text" name="start_date" class="form-control flatpickr" id="start_date" value="{{ \Carbon\Carbon::parse($programme->start_date)->format('d/m/Y') }}" required>
        </div>

        <div class="form-group">
            <label for="end_date">Date de Fin</label>
            <input type="text" name="end_date" class="form-control flatpickr" id="end_date" value="{{ \Carbon\Carbon::parse($programme->end_date)->format('d/m/Y') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Modifier</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('.flatpickr').flatpickr({
            dateFormat: "d/m/Y",
            locale: "fr",
            allowInput: true
        });
    });
</script>
@endsection
