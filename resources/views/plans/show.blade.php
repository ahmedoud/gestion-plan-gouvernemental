@extends('layouts.app')

@section('title', 'Afficher un Plan')

@section('content')
<link rel="stylesheet" href="{{ asset('css/comments.css') }}">
<div class="container plan-details mt-5">
    <div class="card">
        <div class="card-header" style="background-color: #007bff; color: white; padding: 12px 8px;">
            {{ $plan->title }}
        </div>
        <div class="card-body">
            <p><strong>Description :</strong> {{ $plan->description }}</p>
            <p><strong>Date de début :</strong> {{ $plan->start_date }}</p>
            <p><strong>Date de fin :</strong> {{ $plan->end_date }}</p>
            <p><strong>Status :</strong> <span class="badge badge-{{ $plan->status == 'active' ? 'success' : 'secondary' }}">{{ $plan->status }}</span></p>
        </div>
        <div class="card-footer text-right">
            <a href="{{ route('plans.index') }}" class="btn btn-primary">Retour à la liste des plans</a>
        </div>
    </div>

    <!-- Gestion des Commentaires -->
    <div class="card mt-4">
        <div class="card-header" style="background-color: #28a745; color: white;">
            <h3>Commentaires liés à ce plan</h3>
        </div>
        <div class="card-body">
            <!-- Affichage des commentaires existants -->
            @if ($plan->comments->isNotEmpty())
                @foreach($plan->comments as $comment)
                    <div class="comment mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <p>
                                <strong>{{ $comment->user->name }}</strong>
                                (ID Utilisateur: {{ $comment->user->id }})
                                <span class="badge badge-info">
                                    {{ $comment->user->roles->isNotEmpty() ? $comment->user->roles->first()->name : 'Aucun rôle' }}
                                </span>
                            </p>
                            <small class="text-muted">{{ $comment->created_at->format('d-m-Y H:i') }}</small>
                        </div>
                        <p>{{ $comment->content }}</p>
                        <!-- Actions sur les commentaires -->
                        @if(auth()->id() === $comment->user_id || auth()->user()->isAdmin())
                            <form action="{{ route('comments.delete', $comment->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        @endif
                    </div>
                    <hr>
                @endforeach
            @else
                <p>Aucun commentaire pour ce plan.</p>
            @endif

            <form action="{{ route('plans.addComment', $plan->id) }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="content">Ajouter un commentaire</label>
        <textarea name="content" id="content" rows="3" class="form-control" placeholder="Écrivez votre commentaire ici..." required></textarea>
    </div>
    <button type="submit" class="btn btn-success mt-2">Publier</button>
</form>

        </div>
    </div>
</div>
@endsection
