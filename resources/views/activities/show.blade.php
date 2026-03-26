@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header" style="background-color: #007bff; color: white; padding: 12px 8px;">
            <h3>Détails de l'Activité : {{ $activity->title }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Description :</strong> {{ $activity->description }}</p>
            <p><strong>Date de Début :</strong> {{ $activity->start_date ? \Carbon\Carbon::parse($activity->start_date)->format('d/m/Y') : '' }}</p>
            <p><strong>Date de Fin :</strong> {{ $activity->end_date ? \Carbon\Carbon::parse($activity->end_date)->format('d/m/Y') : '' }}</p>
            <p><strong>Avancement :</strong> {{ $activity->progress }}%</p>
            <p><strong>Budget :</strong> {{ $activity->budget }} MRU</p>

            <!-- Affichage des jalons de l'activité -->
            <h5 class="mt-4">Jalons</h5>
            @foreach($activity->milestones as $milestone)
                <div class="mb-3">
                    <h6>{{ $milestone->title }}</h6>
                    <p><strong>Description :</strong> {{ $milestone->description }}</p>
                    <p><strong>Date d'Échéance :</strong> {{ \Carbon\Carbon::parse($milestone->due_date)->format('d/m/Y') }}</p>
                </div>
            @endforeach
        </div>
        <div class="card-footer text-right">
        <a href="{{ route('activities.index', ['plan' => $plan->id]) }}" class="btn btn-primary">Retour à la Liste des Activités</a>
        </div>
    </div>
</div>
@endsection
