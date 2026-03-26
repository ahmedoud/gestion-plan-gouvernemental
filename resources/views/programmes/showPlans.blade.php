<!-- resources/views/programmes/showPlans.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plans for Programme</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Plans for Programme: {{ $programme->title }}</h1>
    <ul>
        @foreach ($plans as $plan)
            <li>{{ $plan->title }}: {{ $plan->description }}</li>
        @endforeach
    </ul>
</div>
</body>
</html>
