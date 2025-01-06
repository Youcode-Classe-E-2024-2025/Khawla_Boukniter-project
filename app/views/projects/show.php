<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><?= htmlspecialchars($project['title']) ?></h4>
                <?php if ($canEdit): ?>
                    <div>
                        <a href="<?= base_url('projects/') ?><?= $project['id'] ?>/edit" class="btn btn-secondary btn-sm">Modifier</a>
                        <form action="<?= base_url('projects/') ?><?= $project['id'] ?>/delete" method="POST" class="d-inline">
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')">
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
            </div>
        </div>

        <!-- Section des tâches sera ajoutée ici  -->
    </div>

    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Membres du projet</h5>
            </div>
            <div class="card-body">
                <?php if ($canEdit): ?>
                    <form action="<?= base_url('projects/') ?><?= $project['id'] ?>/invite" method="POST" class="mb-3">
                        <div class="input-group">
                            <input type="email" class="form-control" name="email" placeholder="Email du membre" required style="background-color: #f8f9fa; color: black">
                            <button type="submit" class="btn btn-primary">Inviter</button>
                        </div>
                    </form>
                <?php endif; ?>

                <?php if (empty($members)): ?>
                    <p class="">Aucun membre dans ce projet.</p>
                <?php else: ?>
                    <ul class="list-group">
                        <?php foreach ($members as $member): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= htmlspecialchars($member['name']) ?>
                                <?php if ($member['status'] === 'pending'): ?>
                                    <span class="badge bg-warning">En attente</span>
                                <?php endif; ?>
                                <?php if ($canEdit && $member['status'] === 'accepted'): ?>
                                    <form action="<?= base_url('projects/') ?><?= $project['id'] ?>/members/<?= $member['id'] ?>/remove"
                                        method="POST" class="d-inline">
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Retirer ce membre du projet ?')">
                                            Retirer
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