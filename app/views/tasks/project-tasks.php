<div class="row mb-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Tâches du projet: <?= htmlspecialchars($project['title']) ?></h2>
            <?php if ($isManager): ?>
                <a href="/projects/<?= $project['id'] ?>/tasks/create" class="btn btn-primary">
                    Nouvelle tâche
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Statistiques des tâches -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-body">
                <h5 class="card-title">À faire</h5>
                <h2 class="card-text"><?= $taskStats['todo'] ?? 0 ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">En cours</h5>
                <h2 class="card-text"><?= $taskStats['doing'] ?? 0 ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Terminées</h5>
                <h2 class="card-text"><?= $taskStats['done'] ?? 0 ?></h2>
            </div>
        </div>
    </div>
</div>

<!-- Liste des tâches -->
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">À faire</h5>
            </div>
            <div class="card-body">
                <?php foreach ($tasks as $task): ?>
                    <?php if ($task['status'] === 'todo'): ?>
                        <?= renderTaskCard($task, $project['id'], $isManager) ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">En cours</h5>
            </div>
            <div class="card-body">
                <?php foreach ($tasks as $task): ?>
                    <?php if ($task['status'] === 'doing'): ?>
                        <?= renderTaskCard($task, $project['id'], $isManager) ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Terminées</h5>
            </div>
            <div class="card-body">
                <?php foreach ($tasks as $task): ?>
                    <?php if ($task['status'] === 'done'): ?>
                        <?= renderTaskCard($task, $project['id'], $isManager) ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php
function renderTaskCard($task, $projectId, $isManager) {
    $tagClasses = [
        'basic' => 'bg-secondary',
        'bug' => 'bg-danger',
        'feature' => 'bg-primary'
    ];
    
    ob_start();
?>
    <div class="card mb-3">
        <div class="card-body">
            <h6 class="card-title"><?= htmlspecialchars($task['title']) ?></h6>
            <p class="card-text small"><?= nl2br(htmlspecialchars($task['description'])) ?></p>
            
            <div class="mb-2">
                <span class="badge <?= $tagClasses[$task['tag']] ?>"><?= ucfirst($task['tag']) ?></span>
                <?php if ($task['category_name']): ?>
                    <span class="badge bg-info"><?= htmlspecialchars($task['category_name']) ?></span>
                <?php endif; ?>
            </div>
            
            <?php if ($task['assigned_to_name']): ?>
                <p class="card-text small mb-2">
                    <i class="bi bi-person"></i> <?= htmlspecialchars($task['assigned_to_name']) ?>
                </p>
            <?php endif; ?>
            
            <p class="card-text small mb-2">
                <i class="bi bi-calendar"></i> <?= date('d/m/Y', strtotime($task['deadline'])) ?>
            </p>

            <div class="d-flex justify-content-between align-items-center">
                <?php if ($isManager): ?>
                    <div class="btn-group">
                        <a href="/projects/<?= $projectId ?>/tasks/<?= $task['id'] ?>/edit" 
                           class="btn btn-sm btn-outline-secondary">
                            Modifier
                        </a>
                        <form action="/projects/<?= $projectId ?>/tasks/<?= $task['id'] ?>/delete" 
                              method="POST" class="d-inline">
                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Supprimer cette tâche ?')">
                                Supprimer
                            </button>
                        </form>
                    </div>
                <?php endif; ?>

                <?php if ($isManager || $_SESSION['user_id'] === $task['assigned_to']): ?>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" 
                                type="button" data-bs-toggle="dropdown">
                            Statut
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <form action="/projects/<?= $projectId ?>/tasks/<?= $task['id'] ?>/status" method="POST">
                                    <input type="hidden" name="status" value="todo">
                                    <button type="submit" class="dropdown-item">À faire</button>
                                </form>
                            </li>
                            <li>
                                <form action="/projects/<?= $projectId ?>/tasks/<?= $task['id'] ?>/status" method="POST">
                                    <input type="hidden" name="status" value="doing">
                                    <button type="submit" class="dropdown-item">En cours</button>
                                </form>
                            </li>
                            <li>
                                <form action="/projects/<?= $projectId ?>/tasks/<?= $task['id'] ?>/status" method="POST">
                                    <input type="hidden" name="status" value="done">
                                    <button type="submit" class="dropdown-item">Terminée</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php
    return ob_get_clean();
}
?>
