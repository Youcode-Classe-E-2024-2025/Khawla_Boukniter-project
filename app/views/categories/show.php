<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2><?= htmlspecialchars($category['name']) ?></h2>
                <p class="text-muted">
                    Projet: <?= htmlspecialchars($project['title']) ?>
                </p>
            </div>
            <?php if ($isManager): ?>
                <div>
                    <a href="/projects/<?= $project['id'] ?>/categories/<?= $category['id'] ?>/edit" 
                       class="btn btn-secondary">
                        Modifier la catégorie
                    </a>
                    <form action="/projects/<?= $project['id'] ?>/categories/<?= $category['id'] ?>/delete" 
                          method="POST" class="d-inline">
                        <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                            Supprimer
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        </div>

        <?php if (empty($tasks)): ?>
            <div class="alert alert-info">
                Aucune tâche n'est assignée à cette catégorie.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tâche</th>
                            <th>Statut</th>
                            <th>Assignée à</th>
                            <th>Tag</th>
                            <th>Date limite</th>
                            <?php if ($isManager): ?>
                                <th>Actions</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task): ?>
                            <tr>
                                <td><?= htmlspecialchars($task['title']) ?></td>
                                <td>
                                    <?php
                                    $statusClasses = [
                                        'todo' => 'bg-secondary',
                                        'in_progress' => 'bg-info',
                                        'done' => 'bg-success'
                                    ];
                                    $statusLabels = [
                                        'todo' => 'À faire',
                                        'in_progress' => 'En cours',
                                        'done' => 'Terminée'
                                    ];
                                    ?>
                                    <span class="badge <?= $statusClasses[$task['status']] ?>">
                                        <?= $statusLabels[$task['status']] ?>
                                    </span>
                                </td>
                                <td>
                                    <?= $task['assigned_to_name'] ? htmlspecialchars($task['assigned_to_name']) : 'Non assignée' ?>
                                </td>
                                <td>
                                    <?php
                                    $tagClasses = [
                                        'basic' => 'bg-secondary',
                                        'bug' => 'bg-danger',
                                        'feature' => 'bg-primary'
                                    ];
                                    ?>
                                    <span class="badge <?= $tagClasses[$task['tag']] ?>">
                                        <?= ucfirst($task['tag']) ?>
                                    </span>
                                </td>
                                <td><?= date('d/m/Y', strtotime($task['deadline'])) ?></td>
                                <?php if ($isManager): ?>
                                    <td>
                                        <a href="/projects/<?= $project['id'] ?>/tasks/<?= $task['id'] ?>/edit" 
                                           class="btn btn-sm btn-outline-secondary">
                                            Modifier
                                        </a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <div class="mt-4">
            <a href="/projects/<?= $project['id'] ?>/categories" class="btn btn-secondary">
                Retour aux catégories
            </a>
        </div>
    </div>
</div>
