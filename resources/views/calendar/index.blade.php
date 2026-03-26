@extends('layouts.app')

@section('title', 'Calendrier des Programmes et Plans')

@section('content')
<div class="container mt-4">
    <h2 class="text-center">Calendrier des Programmes et Plans</h2>
    <div id="calendar"></div>
</div>
@endsection

@section('scripts')
<!-- Inclusion de FullCalendar et de la localisation française -->
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core/locales/fr.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'fr', // Mettre en français
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek,dayGridDay'
            },
            buttonText: {
                today: 'Aujourd\'hui',
                month: 'Mois',
                week: 'Semaine',
                day: 'Jour'
            },
            themeSystem: 'bootstrap',
            events: "{{ route('calendar.events') }}", // Charger les événements via Laravel
            eventClick: function(info) {
                alert('Programme/Plan: ' + info.event.title + "\n" + 'Cliquez pour voir plus de détails.');
                window.location.href = info.event.url;
            },
            eventDidMount: function(info) {
                console.log("Événement chargé: " + info.event.title);
            },
            height: 'auto',
            contentHeight: 'auto'
        });

        calendar.render();
    });
</script>
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/main.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/main.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap@6.1.8/main.css" rel="stylesheet">

<style>
    /* Réduire la hauteur des cases de l'agenda */
    .fc-daygrid-day {
        height: 50px !important;
        min-height: 50px;
    }

    /* Taille du texte des numéros des jours */
    .fc-daygrid-day-number {
        font-size: 0.75rem;
    }

    /* Taille du texte des événements */
    .fc-daygrid-event {
        font-size: 0.7rem;
        padding: 2px;
    }

    /* Taille du titre de l'en-tête */
    .fc-toolbar-title {
        font-size: 1rem;
    }

    /* Taille des jours de la semaine */
    .fc-daygrid-day-top {
        font-size: 0.75rem;
    }

    /* Taille des en-têtes de colonnes */
    .fc-col-header-cell {
        font-size: 0.75rem;
        padding: 3px;
    }
</style>
@endsection
