<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport du Programme: {{ $programme->title }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1, h2, h3, h4 { color: #4CAF50; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <h1>Rapport du Programme: {{ $programme->title }}</h1>
    <p><strong>Description: </strong>{{ $programme->description }}</p>
    <p><strong>Secteur: </strong>{{ $programme->secteur ? $programme->secteur->nom : 'N/A' }}</p>
    <p><strong>Date de début: </strong>{{ \Carbon\Carbon::parse($programme->start_date)->format('d/m/Y') }}</p>
    <p><strong>Date de fin: </strong>{{ \Carbon\Carbon::parse($programme->end_date)->format('d/m/Y') }}</p>
    <p><strong>Status: </strong>{{ $programme->status === 'active' ? 'Actif' : 'Archivé' }}</p>

    <h2>Plans et Détails</h2>
    @foreach ($programme->plans as $plan)
        <h3>Plan: {{ $plan->title }}</h3>
        <p><strong>Description: </strong>{{ $plan->description }}</p>

        <h4>Activités</h4>
        <table>
            <thead>
                <tr>
                    <th>Activité</th>
                    <th>Avancement (%)</th>
                    <th>Sous-activités</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($plan->activities as $activity)
                    <tr>
                        <td>{{ $activity->title }}</td>
                        <td>{{ $activity->progress }}%</td>
                        <td>
                            <ul>
                                @foreach ($activity->subActivities as $subActivity)
                                    <li>
                                        <strong>{{ $subActivity->title }}</strong>
                                        <ul>
                                            @foreach ($subActivity->tasks as $task)
                                                <li>{{ $task->title }}</li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

</body>
</html>
