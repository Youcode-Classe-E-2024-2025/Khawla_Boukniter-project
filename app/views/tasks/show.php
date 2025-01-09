<!-- <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tâches - Kanban</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .kanban {
            color: black;
            display: flex;
            justify-content: space-between;
        }
        .kanban-column {
            flex: 1;
            margin: 0 10px;
            background-color: #f8f8f8eb;
            border-radius: 5px;
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .task {
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }
        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .task-body {
            margin-bottom: 10px;
        }
        .task-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
    <link href="/css/style.css" rel="stylesheet"> 
</head> -->
<style>
        .kanban {
            color: black;
            display: flex;
            justify-content: space-between;
        }
        .kanban-column {
            flex: 1;
            margin: 0 10px;
            background-color: #f8f8f8eb;
            border-radius: 5px;
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .task {
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }
        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .task-body {
            margin-bottom: 10px;
        }
        .task-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .task-title {
            font-weight: bold; 
            color: var(--accent-color);
        }
        .task-description {
            font-size: 1rem; 
            color: #333;
        }
        .task-status {
            background: linear-gradient(to right, #ff4081, #4CAF50);
        }
        .task-title {
            font-size: 1.2rem;
        }
    </style>
<body>
    <div class="container py-4">
        <h1 class="h3">Tâches Assignées</h1>
        <div class="kanban">
            <div class="kanban-column">
                <h5><span class="task-status bg-info badge">To Do</span></h5>
                <?php foreach ($tasks as $task): ?>
                    <?php if ($task['status'] === 'todo'): ?>
                        <div class="task">
                            <div class="task-header">
                                <h4 class="task-title"><?= htmlspecialchars($task['title']) ?></h4>
                                <!-- <span class="badge bg-info task-status"><?= htmlspecialchars($task['status']) ?></span> -->
                            </div>
                            <div class="task-body">
                                <p class="task-description"><em><?= htmlspecialchars($task['description']) ?></em></p>
                                <p class="card-text small mb-2">
                                    <i class="bi bi-calendar"></i> <?= isset($task['deadline']) && $task['deadline'] ? date('d/m/Y', strtotime($task['deadline'])) : 'Date non définie' ?>
                                </p>
                            </div>
                            <div class="task-footer">
                                <div class="d-flex justify-content-between align-items-center">
                                    <!-- Actions pour modifier ou supprimer -->
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="kanban-column">
                <h5><span class="task-status bg-info badge">Doing</span></h5>
                <?php foreach ($tasks as $task): ?>
                    <?php if ($task['status'] === 'doing'): ?>
                        <div class="task">
                            <div class="task-header">
                            <h4 class="task-title"><?= htmlspecialchars($task['title']) ?></h4>
                                <!-- <span class="badge bg-info"><?= htmlspecialchars($task['status']) ?></span> -->
                            </div>
                            <div class="task-body">
                                <p class="task-description"><em><?= htmlspecialchars($task['description']) ?></em></p>
                                <p class="card-text small mb-2">
                                    <i class="bi bi-calendar"></i> <?= isset($task['deadline']) && $task['deadline'] ? date('d/m/Y', strtotime($task['deadline'])) : 'Date non définie' ?>
                                </p>
                            </div>
                            <div class="task-footer">
                                <div class="d-flex justify-content-between align-items-center">
                                    <!-- Actions pour modifier ou supprimer -->
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="kanban-column">
                <h5><span class="task-status bg-info badge">Done</span></h5>
                <?php foreach ($tasks as $task): ?>
                    <?php if ($task['status'] === 'done'): ?>
                        <div class="task">
                            <div class="task-header">
                            <h4 class="task-title"><?= htmlspecialchars($task['title']) ?></h4>
                                <!-- <span class="badge bg-info"><?= htmlspecialchars($task['status']) ?></span> -->
                            </div>
                            <div class="task-body">
                                <p class="task-description"><em><?= htmlspecialchars($task['description']) ?></em></p>
                                <p class="card-text small mb-2">
                                    <i class="bi bi-calendar"></i> <?= isset($task['deadline']) && $task['deadline'] ? date('d/m/Y', strtotime($task['deadline'])) : 'Date non définie' ?>
                                </p>
                            </div>
                            <div class="task-footer">
                                <div class="d-flex justify-content-between align-items-center">
                                    <!-- Actions pour modifier ou supprimer -->
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>
