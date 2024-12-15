<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Modifier la catégorie - <?= htmlspecialchars($project['title']) ?></h4>
            </div>
            <div class="card-body">
                <form action="/projects/<?= $project['id'] ?>/categories/<?= $category['id'] ?>" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom de la catégorie</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="<?= htmlspecialchars($category['name']) ?>" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        <a href="/projects/<?= $project['id'] ?>/categories" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
