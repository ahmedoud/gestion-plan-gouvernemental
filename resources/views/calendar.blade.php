<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier</title>
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/main.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.8/main.min.js"></script>
</head>
<body>
    <h1>Calendrier des Programmes</h1>
    <div id="calendar"></div>

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
                events: @json($events) // Injecte les événements depuis le contrôleur
            });
            calendar.render();
        });
    </script>
</body>
</html>
