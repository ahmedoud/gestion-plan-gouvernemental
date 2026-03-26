@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Modifier la Sous-Activité: {{ $subActivity->title }}</h1>

    <form action="{{ route('sub_activities.update', ['plan' => $planId, 'activity' => $activity->id, 'subActivity' => $subActivity->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ $subActivity->title }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="description" rows="3">{{ $subActivity->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Date de Début</label>
            <input type="date" name="start_date" class="form-control" id="start_date" value="{{ $subActivity->start_date->format('Y-m-d') }}" required>
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">Date de Fin</label>
            <input type="date" name="end_date" class="form-control" id="end_date" value="{{ $subActivity->end_date->format('Y-m-d') }}" required>
        </div>
        <div class="mb-3">
            <label for="progress" class="form-label">Avancement (%)</label>
            <input type="number" name="progress" class="form-control" id="progress" value="{{ $subActivity->progress }}" required>
        </div>
        <div class="mb-3">
            <label for="budget" class="form-label">Budget (MRU)</label>
            <input type="number" name="budget" class="form-control" id="budget" value="{{ $subActivity->budget }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à Jour</button>
    </form>
</div>
@endsection
