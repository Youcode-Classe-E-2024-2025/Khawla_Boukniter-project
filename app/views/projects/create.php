<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Créer un Projet</h4>
            </div>
            <div class="card-body">
                <form action="<?= base_url('projects/create') ?>" method="POST">
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="deadline" class="form-label">Date Limite</label>
                        <input type="date" class="form-control" id="deadline" name="deadline" required>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="is_public" name="is_public">
                        <label class="form-check-label" for="is_public">Projet Public</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Créer le Projet</button>
                </form>
            </div>
        </div>
    </div>
</div>
