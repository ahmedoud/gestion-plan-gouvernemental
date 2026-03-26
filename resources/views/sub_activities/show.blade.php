@extends('layouts.app')

@section('title', 'Détails de la Sous-Activité')

@section('content')
    <div class="container mt-5">
        <h1>Détails de la Sous-Activité : {{ $subActivity->title }}</h1>

        <link rel="stylesheet" href="{{ asset('showsub.css') }}">

        <div class="card mb-3">
            <div class="card-header" style="background-color: #007bff; color: white; padding: 12px 8px;">
                <strong>Description</strong>
            </div>
            <div class="card-body">
                <p>{{ $subActivity->description }}</p>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header" class="card-header" style="background-color: #007bff; color: white; padding: 12px 8px;">
                <strong>Dates</strong>
            </div>
            <div class="card-body">
                <p><strong>Date de début :</strong> {{ $subActivity->start_date ? $subActivity->start_date->format('d/m/Y') : 'Non définie' }}</p>
                <p><strong>Date de fin :</strong> {{ $subActivity->end_date ? $subActivity->end_date->format('d/m/Y') : 'Non définie' }}</p>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header" class="card-header" style="background-color: #007bff; color: white; padding: 12px 8px;">
                <strong>Avancement et Budget</strong>
            </div>
            <div class="card-body">
                <p><strong>Avancement :</strong> {{ $subActivity->progress }}%</p>
                <p><strong>Budget :</strong> {{ $subActivity->budget }} MRU</p>
            </div>
        </div>

        <!-- Bouton Retour -->
        <a href="{{ route('sub_activities.index', ['plan' => $planId, 'activity' => $activity->id]) }}" class="btn btn-primary">Retour à la Liste des Sous-Activités</a>
    </div>

@endsection
