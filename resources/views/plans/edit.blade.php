@extends('layouts.app')

@section('title', 'Edit Plan')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Modifier le Plan</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('plans.update', $plan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Titre :</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $plan->title }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description :</label>
            <textarea name="description" id="description" class="form-control" required>{{ $plan->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="start_date">Date de Début :</label>
            <input type="text" name="start_date" id="start_date" class="form-control flatpickr" value="{{ $plan->start_date }}" placeholder="jj/mm/aaaa" required>
        </div>
        <div class="form-group">
            <label for="end_date">Date de Fin :</label>
            <input type="text" name="end_date" id="end_date" class="form-control flatpickr" value="{{ $plan->end_date }}" placeholder="jj/mm/aaaa" required>
        </div>
        <button type="submit" class="btn btn-primary">Modifier le Plan</button>
    </form>
</div>
@endsection

@push('styles')
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(".flatpickr", {
            dateFormat: "d/m/Y", // Format de la date
            minDate: "today",    // Empêche la sélection de dates antérieures
        });
    });
</script>
@endpush
