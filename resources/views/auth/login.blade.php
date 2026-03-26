<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <!-- Ajout des styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="login-card">
        <!-- Logo -->
        <img src="{{ asset('css/logo.png') }}" alt="Logo MTNIMA">
        <h2><i class="fas fa-sign-in-alt icon"></i> Connexion</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Champ Email -->
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope icon"></i> Adresse Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="error-message">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <!-- Champ Mot de Passe -->
            <div class="form-group">
                <label for="password"><i class="fas fa-lock icon"></i> Mot de passe</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                       name="password" required autocomplete="current-password">
                @error('password')
                <span class="error-message">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <!-- Checkbox Se Souvenir -->
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                       {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Se souvenir de moi</label>
            </div>

            <!-- Bouton Soumettre -->
            <button type="submit" class="btn-primary">Se connecter</button>

            <!-- Lien Mot de Passe Oublié -->
            @if (Route::has('password.request'))
            <div class="forgot-password">
                <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
            </div>
            @endif
        </form>
    </div>
</body>
</html>
