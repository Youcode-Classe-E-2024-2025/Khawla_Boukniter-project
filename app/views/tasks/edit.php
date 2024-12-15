<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Modifier la tâche - <?= htmlspecialchars($project['title']) ?></h4>
            </div>
            <div class="card-body">
                <form action="/projects/<?= $project['id'] ?>/tasks/<?= $task['id'] ?>" method="POST">
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre de la tâche</label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="<?= htmlspecialchars($task['title']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" 
                                  rows="3"><?= htmlspecialchars($task['description']) ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="deadline" class="form-label">Date limite</label>
                                <input type="date" class="form-control" id="deadline" name="deadline" 
                                       value="<?= date('Y-m-d', strtotime($task['deadline'])) ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="priority" class="form-label">Priorité</label>
                                <select class="form-select" id="priority" name="priority">
                                    <option value="1" <?= $task['priority'] == 1 ? 'selected' : '' ?>>Basse</option>
                                    <option value="2" <?= $task['priority'] == 2 ? 'selected' : '' ?>>Moyenne</option>
                                    <option value="3" <?= $task['priority'] == 3 ? 'selected' : '' ?>>Haute</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tag" class="form-label">Tag</label>
                                <select class="form-select" id="tag" name="tag">
                                    <option value="basic" <?= $task['tag'] === 'basic' ? 'selected' : '' ?>>Basic</option>
                                    <option value="bug" <?= $task['tag'] === 'bug' ? 'selected' : '' ?>>Bug</option>
                                    <option value="feature" <?= $task['tag'] === 'feature' ? 'selected' : '' ?>>Feature</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Catégorie</label>
                                <select class="form-select" id="category_id" name="category_id">
                                    <option value="">Aucune catégorie</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>" 
                                                <?= $task['category_id'] == $category['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($category['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="assigned_to" class="form-label">Assigner à</label>
                        <select class="form-select" id="assigned_to" name="assigned_to">
                            <option value="">Non assigné</option>
                            <?php foreach ($members as $member): ?>
                                <?php if ($member['status'] === 'accepted'): ?>
                                    <option value="<?= $member['id'] ?>" 
                                            <?= $task['assigned_to'] == $member['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($member['name']) ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        <a href="/projects/<?= $project['id'] ?>/tasks" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
