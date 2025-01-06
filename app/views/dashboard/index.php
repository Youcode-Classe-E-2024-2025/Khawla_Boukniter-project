<?php
$userRole = $_SESSION['user_role'];
$isManager = $userRole === 'manager';
?>

<div class="container-fluid py-4">
    <!-- En-tête du tableau de bord -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Tableau de bord</h1>
        <?php if ($isManager): ?>
            <a href="<?= base_url('projects/create') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nouveau Projet
            </a>
        <?php endif; ?>
    </div>

    <!-- Cartes de statistiques -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2">Total Projets</h6>
                    <h2 class="card-title mb-0"><?= $projectStats['total'] ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2">Projets Actifs</h6>
                    <h2 class="card-title mb-0"><?= $projectStats['active'] ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2">Tâches En Cours</h6>
                    <h2 class="card-title mb-0"><?= $taskStats['in_progress'] ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2">Tâches Terminées</h6>
                    <h2 class="card-title mb-0"><?= $taskStats['completed'] ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">État des Projets</h5>
                    <canvas id="projectChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">État des Tâches</h5>
                    <canvas id="taskChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tâches à venir -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Tâches à venir</h5>
        </div>
        <div class="card-body">
            <?php if (empty($upcomingTasks)): ?>
                <p class="">Aucune tâche à venir pour les 7 prochains jours.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tâche</th>
                                <th>Projet</th>
                                <th>Date limite</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($upcomingTasks as $task): ?>
                                <tr>
                                    <td><?= htmlspecialchars($task['title']) ?></td>
                                    <td><?= htmlspecialchars($task['project_title']) ?></td>
                                    <td><?= format_date($task['due_date']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= get_status_color($task['status']) ?>">
                                            <?= get_status_label($task['status']) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Scripts pour les graphiques -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Graphique des projets
        new Chart(document.getElementById('projectChart'), {
            type: 'pie',
            data: {
                labels: ['Actifs', 'Terminés'],
                datasets: [{
                    data: [<?= $projectStats['active'] ?>, <?= $projectStats['completed'] ?>],
                    backgroundColor: ['#0d6efd', '#198754']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Graphique des tâches
        new Chart(document.getElementById('taskChart'), {
            type: 'pie',
            data: {
                labels: ['À faire', 'En cours', 'Terminées'],
                datasets: [{
                    data: [
                        <?= $taskStats['todo'] ?>,
                        <?= $taskStats['in_progress'] ?>,
                        <?= $taskStats['completed'] ?>
                    ],
                    backgroundColor: ['#ffc107', '#0dcaf0', '#198754']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });
</script>