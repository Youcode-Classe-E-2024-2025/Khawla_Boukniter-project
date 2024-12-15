<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">Mes Tâches</h2>

        <?php if (empty($tasks)): ?>
            <div class="alert alert-info">
                Vous n'avez pas encore de tâches assignées.
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">À faire</h5>
                        </div>
                        <div class="card-body">
                            <?php foreach ($tasks as $task): ?>
                                <?php if ($task['status'] === 'todo'): ?>
                                    <?= renderMemberTaskCard($task) ?>
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
                                <?php if ($task['status'] === 'in_progress'): ?>
                                    <?= renderMemberTaskCard($task) ?>
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
                                    <?= renderMemberTaskCard($task) ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
function renderMemberTaskCard($task) {
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
            <p class="card-text small text-muted">
                Projet: <?= htmlspecialchars($task['project_title']) ?>
            </p>
            <p class="card-text small"><?= nl2br(htmlspecialchars($task['description'])) ?></p>
            
            <div class="mb-2">
                <span class="badge <?= $tagClasses[$task['tag']] ?>"><?= ucfirst($task['tag']) ?></span>
                <?php if ($task['category_name']): ?>
                    <span class="badge bg-info"><?= htmlspecialchars($task['category_name']) ?></span>
                <?php endif; ?>
            </div>
            
            <p class="card-text small mb-2">
                <i class="bi bi-calendar"></i> <?= date('d/m/Y', strtotime($task['deadline'])) ?>
            </p>

            <div class="dropdown">
                <button class="btn btn-sm btn-outline-primary dropdown-toggle" 
                        type="button" data-bs-toggle="dropdown">
                    Changer le statut
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <form action="/projects/<?= $task['project_id'] ?>/tasks/<?= $task['id'] ?>/status" method="POST">
                            <input type="hidden" name="status" value="todo">
                            <button type="submit" class="dropdown-item">À faire</button>
                        </form>
                    </li>
                    <li>
                        <form action="/projects/<?= $task['project_id'] ?>/tasks/<?= $task['id'] ?>/status" method="POST">
                            <input type="hidden" name="status" value="in_progress">
                            <button type="submit" class="dropdown-item">En cours</button>
                        </form>
                    </li>
                    <li>
                        <form action="/projects/<?= $task['project_id'] ?>/tasks/<?= $task['id'] ?>/status" method="POST">
                            <input type="hidden" name="status" value="done">
                            <button type="submit" class="dropdown-item">Terminée</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
<?php
    return ob_get_clean();
}
?>
