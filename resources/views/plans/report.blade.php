<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport du Plan</title>
</head>
<body>
    <h1>Rapport du Plan: {{ $plan->title }}</h1>
    <p><strong>Description:</strong> {{ $plan->description }}</p>
    <p><strong>Date de début:</strong> {{ \Carbon\Carbon::parse($plan->start_date)->format('d/m/Y') }}</p>
    <p><strong>Date de fin:</strong> {{ \Carbon\Carbon::parse($plan->end_date)->format('d/m/Y') }}</p>
    <p><strong>Status:</strong> {{ $plan->status === 'active' ? 'Actif' : 'Archivé' }}</p>

    <!-- Ajouter d'autres informations que vous voulez dans le rapport -->
    <!-- Par exemple, vous pouvez ajouter les activités associées à ce plan -->
</body>
</html>
