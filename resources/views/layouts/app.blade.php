<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Gestion des plans d'action et des programmes gouvernementaux de MTNIMA</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom CSS -->
    <style>
        /* General Body */
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #1E293B; /* Bleu foncé gouvernemental */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding-left: 275px; /* Alignement avec la sidebar */
        }

        .navbar-brand {
            font-weight: bold;
            color: #fff !important;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }

        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }

        .navbar-nav .nav-link {
            color: #fff !important;
            font-size: 1rem;
        }

        .navbar-nav .nav-link:hover {
            color: #ffcc00 !important; /* Jaune pour le survol */
        }

        /* Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 275px;
            background-color: #1E293B; /* Bleu foncé */
            color: white;
            z-index: 1000;
            transition: width 0.2s ease-in-out;
        }

        .sidebar a {
            color: #ddd;
            text-decoration: none;
            font-size: 16px;
            padding: 15px 20px;
            display: block;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
        }

        .sidebar a:hover {
            background-color: #334155;
            color: #ffffff;
        }

        .sidebar a.active {
            background-color: #475569;
            color: #ffffff;
        }

        .sidebar .sidebar-header {
            text-align: center;
            padding: 20px 10px;
            border-bottom: 1px solid #2e3844;
        }

        .sidebar .sidebar-header img {
            border-radius: 50%;
            width: 70px;
            height: 70px;
            margin-bottom: 10px;
        }

        .sidebar .list-group {
            margin-top: 20px;
        }

        .list-group-item {
            background: none;
            border: none;
            padding: 10px 15px;
        }

        .list-group-item:hover {
            background-color: #475569;
        }

        /* Main Content */
        .main-content {
            margin-left: 275px;
            padding: 20px;
            background-color: #fff;
            min-height: 100vh;
            transition: margin-left 0.2s ease-in-out;
        }

        /* Table Styling */
        .table th {
            background-color: #004080; /* Bleu foncé gouvernemental */
            color: white;
            text-align: center;
            padding: 12px 8px;
        }

        .table td {
            vertical-align: middle;
        }

        /* Buttons */
        .btn-primary {
            background-color: #004080;
            border-color: #004080;
        }

        .btn-primary:hover {
            background-color: #00264d;
            border-color: #00264d;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #5a6268;
        }

        /* Admin Image */
        .admin-img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Style for nested list items */
        .sidebar .list-group .list-group-item {
            padding-left: 40px;
        }

        /* Style for the chevron icon */
        .sidebar .list-group-item .fa-chevron-down {
            transition: transform 0.3s ease-in-out;
        }

        .sidebar .list-group-item[aria-expanded="true"] .fa-chevron-down {
            transform: rotate(180deg);
        }
    </style>
</head>
<body>
<div id="app">
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/login') }}">
                    <img src="{{ asset('css/img/logo-gouvernement.png') }}" alt="Logo">
                    Gestion des plans d'action et des programmes gouvernementaux de MTNIMA
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <!-- Notifications -->
                            <li class="nav-item notification-dropdown">
                                <a class="nav-link" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-bell"></i>
                                    @if (count($notifications = Auth::user()->tasks()->where('end_date', '>=', now())->where('end_date', '<=', now()->addDays(3))->get()) > 0)
                                        <span class="badge">{{ count($notifications) }}</span>
                                    @endif
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown">
                                    @if (count($notifications) > 0)
                                        @foreach ($notifications as $task)
                                            <div class="notification-item">
                                                <a href="{{ route('tasks.show', [
                                                    'plan' => $task->subActivity->activity->plan->id,
                                                    'activity' => $task->subActivity->activity->id,
                                                    'subActivity' => $task->subActivity->id,
                                                    'task' => $task->id,
                                                ]) }}">
                                                    La tâche "{{ $task->title }}" arrive à échéance le {{ $task->end_date->format('d/m/Y') }}.
                                                </a>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="notification-item">
                                            Aucune notification.
                                        </div>
                                    @endif
                                </div>
                            </li>

                            <!-- User Dropdown -->
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> Se déconnecter
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                        <input type="hidden" name="redirect_to" value="{{ url('/login') }}">
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Sidebar -->
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                @php
                    // Vérifie le rôle de l'utilisateur et définit l'image en conséquence
                    if (Auth::check()) {
                        if (Auth::user()->hasRole('admin')) {
                            $image = 'administrator.png';
                        } elseif (Auth::user()->hasRole('responsable')) {
                            $image = 'responsable.png';
                        } else {
                            $image = 'UtilisateurSimple.png';
                        }
                    } else {
                        $image = 'UtilisateurSimple.png';
                    }
                @endphp
                <img src="{{ asset('css/img/' . $image) }}" alt="Image de profil" class="admin-img">
                <p>{{ Auth::check() ? Auth::user()->name : 'Utilisateur' }}</p>
            </div>

            <div class="list-group">
                <a href="{{ route('dashboard') }}" class="list-group-item">
                    <i class="fas fa-home"></i> <span>Tableau de Bord</span>
                </a>
                @if(auth()->check() && auth()->user()->hasRole('admin'))
                    <a href="#gestionUtilisateurs" class="list-group-item" data-toggle="collapse">
                        <i class="fas fa-users"></i> <span>Gestion des utilisateurs</span>
                        <i class="fas fa-chevron-down float-right"></i>
                    </a>
                    <div id="gestionUtilisateurs" class="collapse">
                        <a href="{{ route('users.index') }}" class="list-group-item">
                            <i class="fas fa-user"></i> <span>Utilisateurs</span>
                        </a>
                        <a href="{{ route('roles.index') }}" class="list-group-item">
                            <i class="fas fa-lock"></i> <span>Gestion des rôles</span>
                        </a>
                        <a href="{{ route('permissions.index') }}" class="list-group-item">
                            <i class="fas fa-key"></i> <span>Gestion des permissions</span>
                        </a>
                    </div>
                @endif
                <a href="{{ route('secteurs.index') }}" class="list-group-item">
                    <i class="fas fa-building"></i> <span>Secteurs</span>
                </a>
                <a href="{{ route('programmes.index') }}" class="list-group-item">
                    <i class="fas fa-folder-open"></i> <span>Programmes</span>
                </a>
                <a href="{{ route('plans.index') }}" class="list-group-item">
                    <i class="fas fa-project-diagram"></i> <span>Plans</span>
                </a>
                <a href="{{ route('calendar.index') }}" class="list-group-item">
                    <i class="fas fa-calendar"></i> <span>Calendrier</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <main class="main-content" id="main-content">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script>
        // Sidebar toggle for collapsing
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');

        sidebar.addEventListener('mouseenter', () => sidebar.classList.remove('collapsed'));
        sidebar.addEventListener('mouseleave', () => sidebar.classList.add('collapsed'));

        // Function to set the active class based on the current URL
        function setActiveSidebarItem() {
            const currentUrl = window.location.href;
            const sidebarItems = document.querySelectorAll('.sidebar .list-group-item');

            sidebarItems.forEach(item => {
                const itemUrl = item.getAttribute('href');
                if (currentUrl === itemUrl) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            });
        }

        // Call the function on page load
        document.addEventListener('DOMContentLoaded', setActiveSidebarItem);
    </script>
    @yield('scripts')
</body>
</html>