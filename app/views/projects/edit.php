<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Modifier le projet</h4>
            </div>
            <div class="card-body">
                <form action="/projects/<?= $project['id'] ?>/edit" method="POST">
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre du projet</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="<?= htmlspecialchars($project['title']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description"
                            rows="4"><?= htmlspecialchars($project['description']) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="deadline" class="form-label">Date limite</label>
                        <input type="date" class="form-control" id="deadline" name="deadline"
                            value="<?= date('Y-m-d', strtotime($project['deadline'])) ?>" required>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_public" name="is_public" value="1"
                            <?= $project['is_public'] ? 'checked' : '' ?>>
                        <label class="form-check-label" for="is_public">Projet public</label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        <a href="/projects/<?= $project['id'] ?>" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>