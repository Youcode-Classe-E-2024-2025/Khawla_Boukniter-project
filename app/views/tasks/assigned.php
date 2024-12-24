<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Mes Tâches</h4>
            </div>
            <div class="card-body">
                <?php if (empty($tasks)): ?>
                    <p>Aucune tâche assignée.</p>
                <?php else: ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Description</th>
                                <th>Statut</th>
                                <th>Date Limite</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tasks as $task): ?>
                                <tr>
                                    <td><?= htmlspecialchars($task['title']) ?></td>
                                    <td><?= htmlspecialchars($task['description']) ?></td>
                                    <td><?= htmlspecialchars($task['status']) ?></td>
                                    <td><?= htmlspecialchars($task['deadline']) ?></td>
                                    <td>
                                        <a href="<?= base_url('tasks/update-status/' . $task['id']) ?>" class="btn btn-warning">Mettre à Jour le Statut</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
