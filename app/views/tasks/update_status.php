<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Mettre à Jour le Statut de la Tâche</h4>
            </div>
            <div class="card-body">
                <form action="<?= base_url("tasks/update_status/{$task['id']}") ?>" method="POST">
                    <div class="mb-3">
                        <label for="status" class="form-label">Sélectionnez le Statut</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="todo" <?= $task['status'] === 'todo' ? 'selected' : '' ?>>À faire</option>
                            <option value="in_progress" <?= $task['status'] === 'in_progress' ? 'selected' : '' ?>>En cours</option>
                            <option value="completed" <?= $task['status'] === 'completed' ? 'selected' : '' ?>>Terminé</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Mettre à Jour le Statut</button>
                </form>
            </div>
        </div>
    </div>
</div>