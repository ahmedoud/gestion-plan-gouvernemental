@extends('layouts.app') <!-- Inclut le layout principal -->

@section('content') <!-- Section principale pour le contenu -->
<div class="container mt-5">
    <h1 class="mb-4">Détails de l'utilisateur : {{ $user->name }}</h1>

    <div class="card">
        <div class="card-body text-center"> <!-- Centrer le contenu -->
            <h5 class="card-title">Informations de l'utilisateur</h5>

            <!-- Choisir l'image en fonction du rôle -->
            @php
                $role = $user->roles->pluck('name')->first(); // Récupère le premier rôle de l'utilisateur
                $imagePath = 'css/img/UtilisateurSimple.png'; // Image par défaut

                if ($role === 'admin') {
                    $imagePath = 'css/img/administrator.png';
                } elseif ($role === 'responsable') {
                    $imagePath = 'css/img/responsable.png';
                }
            @endphp

            <!-- Affichage de la photo en fonction du rôle -->
            <img src="{{ asset($imagePath) }}" alt="Photo de l'utilisateur" class="admin-img mb-3">

            <p class="card-text"><strong>Email :</strong> {{ $user->email }}</p>
            <p class="card-text"><strong>Rôles :</strong> {{ implode(', ', $user->roles->pluck('name')->toArray()) }}</p>

            <p class="card-text"><strong>Tâches :</strong></p>
            @if($user->tasks->isNotEmpty())
                <ul>
                    @foreach($user->tasks as $task)
                        <li>
                            <strong>{{ $task->title }}</strong><br>
                            <em>Description:</em> {{ $task->description }}<br>
                            <em>Date de début:</em> {{ $task->start_date }}<br>
                            <em>Date de fin:</em> {{ $task->end_date }}<br>
                            <em>Progression:</em> {{ $task->progress }}%<br>
                            <em>Budget:</em> {{ number_format($task->budget, 2) }} MRU

                            <!-- Afficher les informations des relations imbriquées -->
                            @if($task->subActivity)
                                <p><strong>Sous-activité :</strong> {{ $task->subActivity->title }}</p>
                                @if($task->subActivity->activity)
                                    <p><strong>Activité :</strong> {{ $task->subActivity->activity->title }}</p>
                                    @if($task->subActivity->activity->plan)
                                        <p><strong>Plan :</strong> {{ $task->subActivity->activity->plan->title }}</p>
                                        @if($task->subActivity->activity->plan->programme)
                                            <p><strong>Programme :</strong> {{ $task->subActivity->activity->plan->programme->title }}</p>
                                            @if($task->subActivity->activity->plan->programme->secteur)
                                                <p><strong>Secteur :</strong> {{ $task->subActivity->activity->plan->programme->secteur->nom }}</p>
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <p>Aucune tâche assignée.</p>
            @endif

            <a href="{{ route('users.index') }}" class="btn btn-primary">Retour à la liste</a>
        </div>
    </div>
</div>
@endsection
