@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Liste des Acteurs</h1>
    <a href="{{ route('actors.create') }}" class="btn btn-primary mb-3">Ajouter un Nouvel Acteur</a>

    @if ($actors->isEmpty())
        <p>Aucun acteur n'est disponible.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Rôle</th>
                    <th>Date de Création</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($actors as $actor)
                    <tr>
                        <td>{{ $actor->name }}</td>
                        <td>{{ $actor->role }}</td>
                        <td>{{ $actor->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('actors.show', $actor->id) }}" class="btn btn-info btn-sm">Voir</a>
                            <a href="{{ route('actors.edit', $actor->id) }}" class="btn btn-warning btn-sm">Éditer</a>
                            <form action="{{ route('actors.destroy', $actor->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet acteur?');">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
