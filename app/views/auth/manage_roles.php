<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Gérer les Rôles</h4>
            </div>
            <div class="card-body">
                <form action="<?= base_url('manage-roles') ?>" method="POST">
                    <select name="user_id">
                        <!-- Remplir avec les utilisateurs -->
                    </select>
                    <select name="role">
                        <option value="project_manager">Chef de Projet</option>
                        <option value="member">Membre</option>
                    </select>
                    <button type="submit">Modifier le Rôle</button>
                </form>
            </div>
        </div>
    </div>
</div>
