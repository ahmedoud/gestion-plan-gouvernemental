@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Éditer Secteur</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('secteurs.update', $secteur->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="nom">Nom du secteur</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="{{ $secteur->nom }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
