<div class="container-fluid py-4">
    <!-- En-tête du tableau de bord -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Tableau de Bord Utilisateur</h1>
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
                    <h6 class="card-subtitle mb-2">Tâches En Cours</h6>
                    <!-- <h2 class="card-title mb-0"><?= $userStats['tasks_in_progress'] ?></h2> -->
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2">Tâches Terminées</h6>
                    <!-- <h2 class="card-title mb-0"><?= $userStats['tasks_completed'] ?></h2> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="row mb-4">
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
                <p>Aucune tâche à venir pour les 7 prochains jours.</p>
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
                                    <td><?= htmlspecialchars($task['title']) ?></td>
                                    <td><?= isset($task['deadline']) && $task['deadline'] ? date('d/m/Y', strtotime($task['deadline'])) : 'Date non définie' ?></td>
                                    <td><span class="badge bg-<?= get_status_color($task['status']) ?>"><?= get_status_label($task['status']) ?></span></td>
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
        // Graphique des tâches
        new Chart(document.getElementById('taskChart'), {
            type: 'pie',
            data: {
                labels: ['À faire', 'En cours', 'Terminées'],
                datasets: [{
                    data: [<?= $userStats['tasks_todo'] ?>, <?= $userStats['tasks_in_progress'] ?>, <?= $userStats['tasks_completed'] ?>],
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