<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tâches - Kanban</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .kanban {
            display: flex;
            justify-content: space-between;
        }
        .kanban-column {
            flex: 1;
            margin: 0 10px;
            background-color: #f8f9fa;
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
    </style>
</head>
<body>
    <div class="container py-4">
        <h1 class="h3">Tâches Assignées</h1>
        <div class="kanban">
            <div class="kanban-column">
                <h5>To Do</h5>
                <?php foreach ($tasks as $task): ?>
                    <?php if ($task['status'] === 'to_do'): ?>
                        <div class="task">
                            <h6><?= htmlspecialchars($task['title']) ?></h6>
                            <p><?= htmlspecialchars($task['description']) ?></p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="kanban-column">
                <h5>Doing</h5>
                <?php foreach ($tasks as $task): ?>
                    <?php if ($task['status'] === 'doing'): ?>
                        <div class="task">
                            <h6><?= htmlspecialchars($task['title']) ?></h6>
                            <p><?= htmlspecialchars($task['description']) ?></p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="kanban-column">
                <h5>Done</h5>
                <?php foreach ($tasks as $task): ?>
                    <?php if ($task['status'] === 'done'): ?>
                        <div class="task">
                            <h6><?= htmlspecialchars($task['title']) ?></h6>
                            <p><?= htmlspecialchars($task['description']) ?></p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>
