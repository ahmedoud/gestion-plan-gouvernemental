@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <div id="dynamic-content">
        @include('partials.default_dashboard_content')
    </div>
</div>
@endsection
