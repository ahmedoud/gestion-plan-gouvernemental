@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Détails du Secteur : {{ $secteur->nom }}</h1>
    <a href="{{ route('secteurs.index') }}" class="btn btn-secondary mb-3">Retour aux secteurs</a>

    <h3>Programmes Associés</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($programmes as $programme)
                <tr>
                    <td>{{ $programme->id }}</td>
                    <td>{{ $programme->title }}</td>
                    <td>{{ $programme->start_date }}</td>
                    <td>{{ $programme->end_date }}</td>
                    <td>
                        <a href="{{ route('programmes.plans', ['programme' => $programme->id]) }}" class="btn btn-primary btn-sm">
                            Voir les Plans
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
