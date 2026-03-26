@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Secteur: {{ $secteur->name }}</h1>

    <h2>Programmes associés</h2>
    <ul>
        @foreach($programmes as $programme)
            <li>{{ $programme->name }}</li>
        @endforeach
    </ul>

    <h2>Plans associés</h2>
    <ul>
        @foreach($plans as $plan)
            <li>{{ $plan->name }}</li>
        @endforeach
    </ul>
</div>
@endsection
