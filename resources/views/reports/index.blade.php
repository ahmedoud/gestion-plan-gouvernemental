<!-- resources/views/reports/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Liste des Plans</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #4CAF50; }
        .plan-list { margin-top: 20px; }
        .plan-item { margin-bottom: 20px; }
        .btn { padding: 10px 15px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px; }
        .btn:hover { background-color: #45a049; }
    </style>
</head>
<body>

    <h1>Liste des Plans</h1>

    <div class="plan-list">
        @foreach ($plans as $plan)
            <div class="plan-item">
                <h3>{{ $plan->title }}</h3>
                <!-- Bouton pour télécharger le rapport PDF du plan -->
                <a href="{{ route('reports.plan', $plan->id) }}" class="btn">Télécharger le Rapport</a>
            </div>
        @endforeach
    </div>

</body>
</html>
