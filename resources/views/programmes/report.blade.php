<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport du Programme</title>
</head>
<body>
    <h1>Rapport du Programme: {{ $programme->title }}</h1>
    <p><strong>Description:</strong> {{ $programme->description }}</p>
    <p><strong>Secteur:</strong> {{ $programme->secteur ? $programme->secteur->nom : 'N/A' }}</p>
    <p><strong>Date de début:</strong> {{ \Carbon\Carbon::parse($programme->start_date)->format('d/m/Y') }}</p>
    <p><strong>Date de fin:</strong> {{ \Carbon\Carbon::parse($programme->end_date)->format('d/m/Y') }}</p>
    <p><strong>Status:</strong> {{ $programme->status === 'active' ? 'Actif' : 'Archivé' }}</p>

    <!-- Ajouter d'autres informations que vous voulez dans le rapport -->
    <!-- Par exemple, vous pouvez ajouter les plans associés à ce programme -->
</body>
</html>
