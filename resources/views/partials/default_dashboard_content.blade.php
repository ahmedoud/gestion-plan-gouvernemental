<!-- resources/views/partials/default_dashboard_content.blade.php -->

<link rel="stylesheet" href="{{ asset('css/dashboard_styles.css') }}">
<script src="{{ asset('js/dashboard_scripts.js') }}"></script>

<!-- Titre du tableau de bord en fonction du rôle -->
@if (Auth::user()->hasRole('admin'))
    <h2 class="mb-4"><i class="fas fa-chart-line"></i> Tableau de Bord Administrateur</h2>
@elseif (Auth::user()->hasRole('responsable'))
    <h2 class="mb-4"><i class="fas fa-chart-line"></i> Tableau de Bord Responsable</h2>
@else
    <h2 class="mb-4"><i class="fas fa-chart-line"></i> Tableau de Bord Utilisateur Simple</h2>
@endif

<!-- Row for Statistics Cards -->
<div class="row">
    <!-- Exemple pour la carte des utilisateurs -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2 clickable-card" onclick="toggleCardFocus(this)">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #184661;">Utilisateurs</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $usersCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user fa-2x" style="color: #184661;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secteurs Card -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2 clickable-card" onclick="toggleCardFocus(this)">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #184661;">Secteurs</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $secteursCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-building fa-2x" style="color: #184661;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Programmes Card -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2 clickable-card" onclick="toggleCardFocus(this)">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #184661;">Programmes</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $programmesCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-folder fa-2x" style="color: #184661;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Plans Card -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2 clickable-card" onclick="toggleCardFocus(this)">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #184661;">Plans</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $plansCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-map fa-2x" style="color: #184661;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Afficher la structure des programmes uniquement si l'utilisateur est associé à des tâches -->
@if($programmes->isNotEmpty())
    <div class="tree-view mt-5">
        <h3>Structure des Programmes</h3>
        @foreach($secteurs as $secteur)
            <!-- Vérifier si le secteur contient des programmes -->
            @if($secteur->programmes->isNotEmpty())
                <ul>
                    <li>
                        <strong><span class="expand-toggle" data-id="{{ $secteur->id }}" data-type="secteur">+</span> Secteur : {{ $secteur->nom }}</strong>
                        <ul class="nested" id="secteur-{{ $secteur->id }}">
                            @foreach($secteur->programmes as $programme)
                                @if($programmes->contains($programme))
                                    <li>
                                        <strong><span class="expand-toggle" data-id="{{ $programme->id }}" data-type="programme">+</span> Programme : {{ $programme->title }}</strong>
                                        <ul class="nested" id="programme-{{ $programme->id }}"></ul>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                </ul>
            @endif
        @endforeach
    </div>
@else
    <div class="alert alert-info mt-5">
        Vous n'êtes associé à aucune tâche. Aucun programme à afficher.
    </div>
@endif

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Fonction pour basculer la classe 'focused' sur un clic
    function toggleCardFocus(card) {
        card.classList.toggle('focused');
    }

    // Gestion des clics sur les éléments .expand-toggle
    document.querySelectorAll('.expand-toggle').forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            const id = this.dataset.id;
            const type = this.dataset.type;
            const targetElement = document.getElementById(type + '-' + id);

            if (targetElement && targetElement.innerHTML === '') {
                loadContent(type, id, targetElement);
            }

            // Basculer l'état (expand/collapse)
            this.innerHTML = (this.innerHTML === '+') ? '-' : '+';
            targetElement.classList.toggle('active');
        });
    });

    // Fonction pour charger le contenu dynamiquement
    function loadContent(type, id, targetElement) {
        let url;
        if (type === 'secteur') {
            url = `/secteurs/${id}/loadProgrammes`;
        } else if (type === 'programme') {
            url = `/programmes/${id}/loadPlans`;
        } else if (type === 'plan') {
            url = `/plans/${id}/loadActivities`;
        } else if (type === 'activity') {
            url = `/activities/${id}/loadSubActivities`;
        } else if (type === 'subActivity') {
            url = `/subActivities/${id}/loadTasks`;
        }

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (!data.length) {
                    targetElement.innerHTML = '<li>Aucune donnée disponible</li>';
                    return;
                }

                let html = '<ul>';
                data.forEach((item) => {
                    let newType = (type === 'secteur') ? 'programme' :
                                  (type === 'programme') ? 'plan' :
                                  (type === 'plan') ? 'activity' :
                                  (type === 'activity') ? 'subActivity' : 'task';

                    // Définir le préfixe en fonction du type
                    let prefix = '';
                    if (newType === 'plan') {
                        prefix = 'Plan : ';
                    } else if (newType === 'activity') {
                        prefix = 'Activité : ';
                    } else if (newType === 'subActivity') {
                        prefix = 'Sous-activité : ';
                    } else if (newType === 'task') {
                        prefix = 'Tâche : ';
                    }

                    html += `<li>
                                <strong>
                                    <span class="expand-toggle" data-id="${item.id}" data-type="${newType}">+</span>
                                    ${prefix}${item.title}`;

                    // Ajouter l'avancement uniquement pour les activités, sous-activités et tâches
                    if (newType === 'activity' || newType === 'subActivity' || newType === 'task') {
                        html += ` (Avancement : ${item.progress}%)`;
                    }

                    html += `</strong>`;

                    if (newType !== 'task') {
                        html += `<ul class="nested" id="${newType}-${item.id}"></ul>`;
                    }
                    html += '</li>';
                });
                html += '</ul>';

                targetElement.innerHTML = html;

                // Réinitialiser les événements sur les nouveaux éléments
                document.querySelectorAll(`#${targetElement.id} .expand-toggle`).forEach(function(newToggle) {
                    newToggle.addEventListener('click', function() {
                        const newId = this.dataset.id;
                        const newType = this.dataset.type;
                        const newTargetElement = document.getElementById(newType + '-' + newId);

                        if (newTargetElement && newTargetElement.innerHTML === '') {
                            loadContent(newType, newId, newTargetElement);
                        }

                        // Basculer l'état (expand/collapse)
                        this.innerHTML = (this.innerHTML === '+') ? '-' : '+';
                        newTargetElement.classList.toggle('active');
                    });
                });
            })
            .catch(error => {
                console.error('Erreur de chargement:', error);
                targetElement.innerHTML = '<li>Erreur lors du chargement</li>';
            });
    }

    // Ajouter des écouteurs d'événements pour le clic sur les cartes
    document.querySelectorAll('.card').forEach(function(card) {
        card.addEventListener('click', function() {
            toggleCardFocus(card);
        });
    });
});
</script>

<script src="{{ asset('js/dashboard_scripts.js') }}"></script>