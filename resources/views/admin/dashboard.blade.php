@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Section with Custom Background and Styles -->
        <div class="col-md-3 sidebar" style="background: black; color: white; position: fixed; top: 0; bottom: 0; left: 0; width: 20%; padding-top: 60px; z-index: 1000;">
            <div class="list-group" id="accordionSidebar">

            <!-- Gestion des utilisateurs -->
            <a href="#" class="list-group-item list-group-item-action" style="color: white; background-color: transparent;" data-toggle="collapse" data-target="#usersMenu" aria-expanded="true" aria-controls="usersMenu">
                    + Gestion des utilisateurs
                </a>
                <div id="usersMenu" class="collapse" aria-labelledby="headingUsers" data-parent="#accordionSidebar">
                    <div class="list-group ml-3">
                        <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action" style="color: white; background-color: transparent;">Voir les utilisateurs</a>
                        <a href="{{ route('users.create') }}" class="list-group-item list-group-item-action" style="color: white; background-color: transparent;">Ajouter un utilisateur</a>
                    </div>
                </div>

        <!-- Secteurs -->
    <a href="#" class="list-group-item list-group-item-action" style="color: white; background-color: transparent;" data-toggle="collapse" data-target="#secteursMenu" aria-expanded="true" aria-controls="secteursMenu">
        + Secteurs
    </a>
    <div id="secteursMenu" class="collapse" aria-labelledby="headingSecteurs" data-parent="#accordionSidebar">
        <div class="list-group ml-3">
            <a href="javascript:void(0);" onclick="loadContent('secteurs-list')" class="list-group-item list-group-item-action" style="color: white; background-color: transparent;">Liste des Secteurs</a>
            <!-- <a href="javascript:void(0);" onclick="loadContent('secteurs-create')" class="list-group-item list-group-item-action" style="color: white; background-color: transparent;">Créer un Secteur</a> -->
        </div>
    </div>


<!-- Programme 1 -->
    <a href="#" class="list-group-item list-group-item-action" style="color: white; background-color: transparent;" data-toggle="collapse" data-target="#programme1Menu" aria-expanded="true" aria-controls="programme1Menu">
        + Programme 1
    </a>
    <div id="programme1Menu" class="collapse" aria-labelledby="headingProgramme1" data-parent="#accordionSidebar">
        <div class="list-group ml-3">
            <a href="javascript:void(0);" onclick="loadContent('programme1-plans')" class="list-group-item list-group-item-action" style="color: white; background-color: transparent;">Plans</a>
            <a href="javascript:void(0);" onclick="loadContent('programme1-activities')" class="list-group-item list-group-item-action" style="color: white; background-color: transparent;">Activités</a>
            <a href="javascript:void(0);" onclick="loadContent('programme1-subactivities')" class="list-group-item list-group-item-action" style="color: white; background-color: transparent;">Sous-Activités</a>
            <a href="javascript:void(0);" onclick="loadContent('programme1-tasks')" class="list-group-item list-group-item-action" style="color: white; background-color: transparent;">Tâches</a>
        </div>
    </div>
                <!-- Programme 2 -->
                <a href="#" class="list-group-item list-group-item-action" style="color: white; background-color: transparent;" data-toggle="collapse" data-target="#programme2Menu" aria-expanded="true" aria-controls="programme2Menu">
                    + Programme 2
                </a>
                <div id="programme2Menu" class="collapse" aria-labelledby="headingProgramme2" data-parent="#accordionSidebar">
                    <div class="list-group ml-3">
                        <a href="{{ route('programmes.plans', 2) }}" class="list-group-item list-group-item-action" style="color: white; background-color: transparent;">Plans</a>
                        <a href="{{ route('activities.index', 2) }}" class="list-group-item list-group-item-action" style="color: white; background-color: transparent;">Activités</a>
                        <a href="{{ route('sub_activities.index', ['plan' => 2, 'activity' => 1]) }}" class="list-group-item list-group-item-action" style="color: white; background-color: transparent;">Sous-Activités</a>
                        <a href="{{ route('tasks.index', ['plan' => 2, 'activity' => 1, 'subActivity' => 1]) }}" class="list-group-item list-group-item-action" style="color: white; background-color: transparent;">Tâches</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Section (Adjusted for Fixed Sidebar) -->
        <div class="col-md-9 offset-md-3" style="padding-top: 0px; padding-left: 0px; padding-right: 100px;">
            <div class="row">
                <!-- Adjusted Stats Cards Section -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Secteurs</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $secteursCount }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-briefcase fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Programmes</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $programmesCount }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tasks fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Utilisateurs</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $usersCount }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dynamic Content Section -->
            <div id="content-area">
                <h1>Bienvenue sur le Tableau de Bord Admin</h1>
                <p>Sélectionnez une option dans la barre latérale pour commencer.</p>
                <div class="text-center" id="loading-spinner" style="display: none;">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Chargement...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add your Modal and Script sections if needed -->

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
async function loadContent(contentId) {
    const contentArea = document.getElementById('content-area');
    const spinner = document.getElementById('loading-spinner');

    spinner.style.display = 'block';  // Afficher le spinner pendant le chargement

    let url;
    switch (contentId) {
        case 'secteurs-list':
            url = '{{ route('secteurs.index') }}';  // URL vers la liste des secteurs
            break;
        case 'secteurs-create':
            url = '{{ route('secteurs.create') }}';  // URL vers la page de création de secteur
            break;

        // Programme 1
        case 'programme1-plans':
            url = '{{ route('programmes.plans', 1) }}';  // URL vers les plans de Programme 1
            break;
        case 'programme1-activities':
            url = '{{ route('activities.index', 1) }}';  // URL vers les activités de Programme 1
            break;
        case 'programme1-subactivities':
            url = '{{ route('sub_activities.index', ['plan' => 1, 'activity' => 1]) }}';  // URL vers les sous-activités de Programme 1
            break;
        case 'programme1-tasks':
            url = '{{ route('tasks.index', ['plan' => 1, 'activity' => 1, 'subActivity' => 1]) }}';  // URL vers les tâches de Programme 1
            break;

        // Programme 2
        case 'programme2-plans':
            url = '{{ route('programmes.plans', 2) }}';  // URL vers les plans de Programme 2
            break;
        case 'programme2-activities':
            url = '{{ route('activities.index', 2) }}';  // URL vers les activités de Programme 2
            break;
        case 'programme2-subactivities':
            url = '{{ route('sub_activities.index', ['plan' => 2, 'activity' => 1]) }}';  // URL vers les sous-activités de Programme 2
            break;
        case 'programme2-tasks':
            url = '{{ route('tasks.index', ['plan' => 2, 'activity' => 1, 'subActivity' => 1]) }}';  // URL vers les tâches de Programme 2
            break;

        default:
            contentArea.innerHTML = '<h1>Bienvenue sur le Tableau de Bord Admin</h1><p>Sélectionnez une option dans la barre latérale pour commencer.</p>';
            spinner.style.display = 'none';
            return;
    }

    try {
        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            throw new Error('Erreur lors du chargement du contenu');
        }

        const content = await response.text();
        contentArea.innerHTML = content;  // Injecter le contenu reçu dans l'élément `#content-area`
    } catch (error) {
        contentArea.innerHTML = '<p>Une erreur s\'est produite lors du chargement du contenu.</p>';
    } finally {
        spinner.style.display = 'none';  // Masquer le spinner une fois le chargement terminé
    }
}

</script>

<!-- Modal pour ajouter un secteur
<div class="modal fade" id="addSecteurModal" tabindex="-1" role="dialog" aria-labelledby="addSecteurModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSecteurModalLabel">Ajouter un Secteur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="secteurForm" method="POST" action="{{ route('secteurs.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Créer</button>
                </div>
            </form>
        </div>
    </div>
</div> -->

@endsection
