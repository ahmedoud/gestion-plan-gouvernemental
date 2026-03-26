<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport du Plan</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1, h2, h3 { color: #4CAF50; }
        h1 { font-size: 24px; }
        h2 { font-size: 20px; margin-top: 20px; }
        h3 { font-size: 18px; margin-top: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .task { margin-left: 20px; font-style: italic; }
        .subactivity { margin-left: 10px; font-weight: bold; }
        .warning { color: red; font-weight: bold; }
    </style>
</head>
<body>

    <h1>Rapport du Plan : {{ $planTitle }}</h1>
    <p><strong>Description :</strong> {{ $planDescription }}</p>
    <p><strong>Période :</strong> {{ $startDate }} - {{ $endDate }}</p>
    <p><strong>Status :</strong> {{ $status }}</p>

    <h2>Activités et Tâches</h2>

    @foreach ($activities as $activity)
        <h3>Activité : {{ $activity['activityTitle'] }} (Progression : {{ $activity['progress'] }}%)</h3>
        @foreach ($activity['subactivities'] as $subactivity)
            <div class="subactivity">Sous-activité : {{ $subactivity['title'] }} (Progression : {{ $subactivity['progress'] }}%)</div>
            @if(!$subactivity['allTasksCompleted'])
                <p class="warning">Attention : Cette sous-activité est marquée comme terminée, mais certaines tâches ne sont pas encore complétées.</p>
            @endif
            <ul>
                @foreach ($subactivity['tasks'] as $task)
                    <li class="task">
                        <strong>Tâche :</strong> {{ $task['title'] }}<br>
                        <small>Échéance : {{ \Carbon\Carbon::parse($task['due_date'])->format('d/m/Y') }}</small>
                        <span>Progression : {{ $task['progress'] }}%</span>
                        @if ($task['progress'] == 100)
                            <span style="color: green;">(Complétée)</span>
                        @else
                            <span style="color: red;">(En cours)</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endforeach
    @endforeach

</body>
</html>