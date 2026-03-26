<div class="modal fade" id="addSecteurModal" tabindex="-1" aria-labelledby="addSecteurLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSecteurLabel">Ajouter un Secteur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('secteurs.store') }}" method="POST" id="createSecteurForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nom">Nom du Secteur</label>
                        <input type="text" name="nom" class="form-control" id="nom" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>
