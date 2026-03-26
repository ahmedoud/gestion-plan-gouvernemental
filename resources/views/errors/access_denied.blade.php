@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <h1>403 - Accès refusé</h1>
        <strong><p>Vous n'avez pas les permissions pour accéder à cette page.</p></strong> 
        <a href="{{ url('/dashboard') }}" class="btn btn-primary">Retour à l'accueil</a>
    </div>
@endsection
