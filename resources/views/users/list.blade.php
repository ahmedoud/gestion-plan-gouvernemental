@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des utilisateurs</h1>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</td> <!-- Afficher les rôles -->
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
