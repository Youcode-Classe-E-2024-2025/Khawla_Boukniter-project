<div class="container mt-5">
    <h1 class="text-center"><?= htmlspecialchars($project['title']) ?></h1>
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><?= htmlspecialchars($project['title']) ?></h4>
                    <?php if ($canEdit): ?>
                        <div>
                            <a href="<?= base_url('projects/') ?><?= $project['id'] ?>/edit" class="btn btn-secondary btn-sm" title="Modifier">
                                Modifier
                            </a>
                            <form action="<?= base_url('projects/') ?><?= $project['id'] ?>/delete" method="POST" class="d-inline">
                                <button type="submit" class="btn btn-secondary btn-sm" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <p class="card-text"><?= nl2br(htmlspecialchars($project['description'])) ?></p>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Chef de projet:</strong> <?= htmlspecialchars($project['manager_name']) ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Date limite:</strong> <?= date('d/m/Y', strtotime($project['deadline'])) ?></p>
                        </div>
                    </div>
                    <p><strong>Visibilité:</strong> <?= $project['is_public'] ? 'Public' : 'Privé' ?></p>
                    <a href="<?= base_url('projects/' . $project['id'] . '/tasks') ?>" class="btn btn-secondary mb-3">Voir les Tâches</a>
                </div>
            </div>

            <div class="card mb-4" style="padding: 1rem;">
                <h2>Tâches Associées</h2>
                <div class="mb-3">
                    <label for="taskFilter" class="form-label">Filtrer par statut :</label>
                    <select id="taskFilter" class="form-select" onchange="filterTasks()" style="width: 20%">
                        <option value="">Tous</option>
                        <option value="todo">À faire</option>
                        <option value="doing">En cours</option>
                        <option value="done">Complété</option>
                    </select>
                </div>

                <table class="table table-striped table-bordered" style="border-radius: 15px;">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Date d'échéance</th>
                            <th>Statut</th>
                            <?php if (is_manager()): ?>
                                <th>Actions</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task): ?>
                            <tr>
                                <td><?= htmlspecialchars($task['title']) ?></td>
                                <td><?= htmlspecialchars($task['description']) ?></td>
                                <td><?= isset($task['deadline']) && $task['deadline'] ? date('d/m/Y', strtotime($task['deadline'])) : 'Date non définie' ?></td>
                                <td>
                                    <span class="badge badge-<?= $task['status'] === 'done' ? 'success' : ($task['status'] === 'doing' ? 'warning' : 'secondary') ?>" style="color: black">
                                        <?= ucfirst($task['status']) ?>
                                    </span>
                                </td>
                                <?php if (is_manager()): ?>
                                <td>
                                    <a href="<?= base_url('projects/' . $project['id'] . '/tasks/' . $task['id'] . '/edit') ?>" class="btn btn-warning btn-sm icone" title="Modifier" style="padding: 0.5rem 1rem;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?= base_url('projects/' . $project['id'] . '/tasks/' . $task['id'] . '/delete') ?>" method="POST" style="display:inline;">
                                        <button type="submit" class="btn btn-warning btn-sm icone" title="Supprimer" style="padding: 0.5rem 1rem;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <script>
                    function filterTasks() {
                        const filter = document.getElementById('taskFilter').value;
                        const rows = document.querySelectorAll('tbody tr');
                        rows.forEach(row => {
                            const status = row.querySelector('.badge').textContent.toLowerCase();
                            if (filter === '' || status.includes(filter)) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        });
                    }
                </script>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Membres du projet</h5>
                </div>
                <div class="card-body">
                    <?php if ($canEdit): ?>
                        <h2>Inviter un Membre</h2>
                        <form action="<?= base_url('projects/') ?><?= $project['id'] ?>/invite" method="POST" class="mb-3">
                            <div class="mb-3">
                                <input type="email" class="form-control" name="email" placeholder="Email du membre" required style="background-color: #f8f9fa; color: black">
                            </div>
                            <div class="mb-3">
                                <label for="permissions" class="form-label">Permissions :</label>
                                <?php 
                                    error_log('Permissions: ' . print_r($allPermissions, true));
                                ?>
                                <select name="permissions[]" id="permissions" class="form-select">
                                    <?php if (!empty($allPermissions)): ?>
                                        <?php foreach ($allPermissions as $permission): ?>
                                            <option value="<?= $permission['id'] ?>"><?= htmlspecialchars($permission['name']) ?></option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option disabled>Aucune permission disponible</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Inviter</button>
                        </form>
                    <?php endif; ?>

                    <?php if (empty($members)): ?>
                        <p class="">Aucun membre dans ce projet.</p>
                    <?php else: ?>
                        <ul class="list-group">
                            <?php foreach ($members as $member): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                <h5><?= htmlspecialchars($member['name']) ?></h5>
                                <div class="permissions">
                                    <?php if (isset($member['permission_name'])): ?>
                                        <span class="badge bg-primary"><?= htmlspecialchars($member['permission_name']) ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Aucune permission</span>
                                    <?php endif; ?>
                                </div>
                                <?php if ($canEdit): ?>
                                    <form action="<?= base_url('projects/') ?><?= $project['id'] ?>/members/<?= $member['id'] ?>/remove" method="POST" class="d-inline">
                                        <button type="submit" class="btn btn-danger btn-sm icone" style="padding: 0; background-color: transparent; color: darkred;"
                                            onclick="return confirm('Retirer ce membre du projet ?')">
                                            <i class="fas fa-user-minus"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>