<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Réinitialiser le mot de passe</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group mb-3">
                                <label for="email">Adresse e-mail</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Nouveau mot de passe</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password_confirmation">Confirmez le mot de passe</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Réinitialiser</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
