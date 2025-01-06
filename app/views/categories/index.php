<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Catégories - <?= htmlspecialchars($project['title']) ?></h2>
            <?php if ($isManager): ?>
                <a href="/projects/<?= $project['id'] ?>/categories/create" class="btn btn-primary">
                    Nouvelle catégorie
                </a>
            <?php endif; ?>
        </div>

        <?php if (empty($categories)): ?>
            <div class="alert alert-info">
                Aucune catégorie n'a été créée pour ce projet.
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($categories as $category): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="card-title"><?= htmlspecialchars($category['name']) ?></h5>
                                        <p class="card-text">
                                            <small class="">
                                                <?= $category['task_count'] ?> tâche(s)
                                            </small>
                                        </p>
                                    </div>
                                    <?php if ($isManager): ?>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle"
                                                type="button" data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="/projects/<?= $project['id'] ?>/categories/<?= $category['id'] ?>/edit">
                                                        Modifier
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="/projects/<?= $project['id'] ?>/categories/<?= $category['id'] ?>/delete"
                                                        method="POST" class="d-inline">
                                                        <button type="submit" class="dropdown-item text-danger"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                                                            Supprimer
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <a href="/projects/<?= $project['id'] ?>/categories/<?= $category['id'] ?>"
                                    class="btn btn-outline-primary btn-sm mt-3">
                                    Voir les tâches
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>