@extends('layouts.app') <!-- Assurez-vous que cette vue utilise votre layout principal -->

@section('content')
    <div class="container">
        <div class="alert alert-danger text-center">
            <h1>403 - Action non autorisée</h1>
            <p>Vous n'avez pas la permission d'effectuer cette action.</p>
            <a href="{{ url()->previous() }}" class="btn btn-primary">Retour</a>
        </div>
    </div>
@endsection