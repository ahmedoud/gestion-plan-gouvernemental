<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserLabel">Créer un Nouveau Utilisateur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('users.store') }}" method="POST" id="createUserForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nom de l'Utilisateur</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email de l'Utilisateur</label>
                        <input type="email" name="email" class="form-control" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Rôle</label>
                        <select name="role" class="form-control" id="role" required>
                            <option value="admin">Admin</option>
                            <option value="plan_manager">Plan Manager</option>
                            <option value="end_user">End User</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Créer</button>
                </div>
            </form>
        </div>
    </div>
</div>
