@extends('layouts.app')

@section('title', 'Calendrier des Programmes')

@section('content')
<div class="container mt-4">
    <h2 class="text-center">Calendrier des Programmes</h2>
    <div id="calendar"></div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap@6.1.8/index.global.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek,dayGridDay'
            },
            themeSystem: 'bootstrap',
            events: "{{ route('calendar.programmes') }}",
            eventClick: function(info) {
                alert('Programme: ' + info.event.title);
            },
        });

        calendar.render();
    });
</script>
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/main.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/main.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap@6.1.8/main.css" rel="stylesheet">
@endsection
