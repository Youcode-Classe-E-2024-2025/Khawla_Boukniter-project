<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Nouvelle tâche - <?= htmlspecialchars($project['title']) ?></h4>
            </div>
            <div class="card-body">
                <form action="<?= base_url('projects/' . $project['id'] . '/tasks') ?>" method="POST">
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre de la tâche</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="deadline" class="form-label">Date limite</label>
                                <input type="date" class="form-control" id="deadline" name="deadline" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Statut</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">Sélectionnez un statut</option>
                                    <option value="doing">En cours</option>
                                    <option value="done">Terminé</option>
                                    <option value="todo">À faire</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Catégorie</label>
                                <select class="form-select" id="category_id" name="category_id">
                                    <option value="">Aucune catégorie</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>">
                                            <?= htmlspecialchars($category['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="category" class="form-label">Nouvelle Catégorie</label>
                            <input type="text" class="form-control" id="category" name="category">
                        </div>
                    </div>

                    
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tags" class="form-label">Tags</label>
                            <input type="text" class="form-control" id="tags" name="tags">
                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="mb-3">
                        <label for="assigned_to" class="form-label">Assigner à</label>
                        <select class="form-select" id="assigned_to" name="assigned_to">
                            <option value="">Sélectionnez un membre</option>
                            <?php foreach ($members as $member): ?>
                                <option value="<?= $member['id'] ?>"><?= htmlspecialchars($member['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    </div>
                </div>

                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Créer la tâche</button>
                        <a href="/projects/<?= $project['id'] ?>/tasks" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.4/tagify.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.9.4/tagify.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var inputTags = document.querySelector('#tags');
        var inputEmails = document.querySelector('#assigned_emails');

        new Tagify(inputTags);
        new Tagify(inputEmails);
    });
</script>
