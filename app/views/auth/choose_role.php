<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Choisir un Rôle</h4>
            </div>
            <div class="card-body">
                <form action="<?= base_url('choose-role') ?>" method="POST">
                    <div class="mb-3">
                        <label for="role" class="form-label">Sélectionnez votre rôle</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="project_manager">Chef de Projet</option>
                            <option value="member">Membre</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Confirmer le Rôle</button>
                </form>
            </div>
        </div>
    </div>
</div>
