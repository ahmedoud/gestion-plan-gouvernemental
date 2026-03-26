@extends('layouts.app')

@section('title', 'Détails du Programme')

@section('content')
<link rel="stylesheet" href="{{ asset('css/comments.css') }}">
<div class="container programme-details">
    <!-- Détails du Programme -->
    <div class="card mb-4">
        <div class="card-header" style="background-color: #007bff; color: white; padding: 12px 8px;">
            <h2>{{ $programme->title }} (ID: {{ $programme->id }})</h2>
        </div>
        <div class="card-body">
            <p><strong>Description :</strong> {{ $programme->description }}</p>
            <p><strong>Date de début :</strong> {{ \Carbon\Carbon::parse($programme->start_date)->format('d-m-Y') }}</p>
            <p><strong>Date de fin :</strong> {{ \Carbon\Carbon::parse($programme->end_date)->format('d-m-Y') }}</p>
            <p><strong>Status :</strong>
                <span class="badge badge-{{ $programme->status == 'active' ? 'success' : 'secondary' }}">
                    {{ $programme->status == 'active' ? 'Actif' : 'Archivé' }}
                </span>
            </p>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center">
            <a href="{{ route('programmes.index') }}" class="btn btn-primary">Retour à la liste des programmes</a>
            <div>
                {{-- Actions pour admin ou responsable --}}
                @if(auth()->user()->isAdmin() || auth()->user()->isResponsable())
                    <a href="{{ route('programmes.edit', $programme->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                @endif

                {{-- Action de suppression uniquement pour admin --}}
                @if(auth()->user()->isAdmin())
                    <form action="{{ route('programmes.destroy', $programme->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Supprimer
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Gestion des Commentaires -->
    <div class="card">
        <div class="card-header" style="background-color: #28a745; color: white;">
            <h3>Commentaires liés à ce programme</h3>
        </div>
        <div class="card-body">
            <!-- Affichage des commentaires existants -->
            @if ($programme->comments->isNotEmpty())
                @foreach($programme->comments as $comment)
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
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i> Supprimer
                                </button>
                            </form>
                        @endif
                    </div>
                    <hr>
                @endforeach
            @else
                <p>Aucun commentaire pour ce programme.</p>
            @endif

            <!-- Formulaire pour ajouter un commentaire -->
            <form action="{{ route('comments.add', $programme->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="content">Ajouter un commentaire</label>
                    <textarea name="content" id="content" rows="3" class="form-control" placeholder="Écrivez votre commentaire ici..." required></textarea>
                </div>
                <button type="submit" class="btn btn-success mt-2">
                    <i class="fas fa-paper-plane"></i> Publier
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
