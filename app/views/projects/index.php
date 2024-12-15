<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><?= $isPublic ? 'Projets Publics' : 'Mes Projets' ?></h2>
            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'project_manager'): ?>
                <a href="/projects/create" class="btn btn-primary">Nouveau Projet</a>
            <?php endif; ?>
        </div>

        <?php if (empty($projects)): ?>
            <div class="alert alert-info">
                <?= $isPublic ? 'Aucun projet public disponible.' : 'Vous n\'avez pas encore de projets.' ?>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($projects as $project): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($project['title']) ?></h5>
                                <p class="card-text">
                                    <?= nl2br(htmlspecialchars(substr($project['description'], 0, 150))) ?>
                                    <?= strlen($project['description']) > 150 ? '...' : '' ?>
                                </p>
                                <p class="card-text">
                                    <small class="text-muted">
                                        Chef de projet: <?= htmlspecialchars($project['manager_name']) ?>
                                    </small>
                                </p>
                                <p class="card-text">
                                    <small class="text-muted">
                                        Date limite: <?= date('d/m/Y', strtotime($project['deadline'])) ?>
                                    </small>
                                </p>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="/projects/<?= $project['id'] ?>" class="btn btn-primary btn-sm">
                                    Voir le projet
                                </a>
                                <?php if (isset($_SESSION['user_role']) && 
                                        $_SESSION['user_role'] === 'project_manager' && 
                                        $project['manager_id'] === $_SESSION['user_id']): ?>
                                    <a href="/projects/<?= $project['id'] ?>/edit" class="btn btn-secondary btn-sm">
                                        Modifier
                                    </a>
                                    <form action="/projects/<?= $project['id'] ?>/delete" method="POST" class="d-inline">
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')">
                                            Supprimer
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
