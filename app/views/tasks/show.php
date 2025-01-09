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
    <div class="container py-4">
        <h1 class="h3">Tâches Assignées</h1>
        <div class="mb-3">
            <a href="<?= base_url('projects/' . $project['id'] . '/tasks/create') ?>" class="btn btn-primary">Ajouter une Tâche</a>
        </div>
        <div class="kanban">
            <div class="kanban-column" ondragover="allowDrop(event)" ondrop="drop(event, 'todo')">
                <h5><span class="task-status bg-info badge">To Do</span></h5>
                <?php foreach ($tasks as $task): ?>
                    <?php if ($task['status'] === 'todo'): ?>
                        <div class="task" draggable="true" data-id="<?= $task['id']?>" ondragstart="drag(event)">
                            <div class="task-header">
                                <h4 class="task-title"><?= htmlspecialchars($task['title']) ?></h4>
                                <!-- <span class="badge bg-info task-status"><?= htmlspecialchars($task['status']) ?></span> -->
                            </div>
                            <div class="task-body">
                                <p class="task-description"><em><?= htmlspecialchars($task['description']) ?></em></p>
                                <p class="card-text small mb-2">
                                    <i class="bi bi-calendar"></i> <?= isset($task['deadline']) && $task['deadline'] ? date('d/m/Y', strtotime($task['deadline'])) : 'Date non définie' ?>
                                </p>
                                <div class="mb-3">
                                    

                                    <!-- Modal -->
                                    <div class="modal fade" id="assignModal<?= $task['id'] ?>" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="assignModalLabel">Assigner à un membre</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <select class="form-select" id="assigned_to" name="assigned_to">
                                                        <option value="">Sélectionnez un membre</option>
                                                        <?php foreach ($members as $member): ?>
                                                            <option value="<?= $member['id'] ?>"><?= htmlspecialchars($member['name']) ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <button type="button" class="btn btn-primary">Assigner</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="task-footer">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="<?= base_url('projects/' . $project['id'] . '/tasks/' . $task['id'] . '/edit') ?>" class="btn btn-warning btn-sm icone" title="Modifier" style="padding: 0.5rem 1rem;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?= base_url('projects/' . $project['id'] . '/tasks/' . $task['id'] . '/delete') ?>" method="POST" style="display:inline;">
                                        <button type="submit" class="btn btn-danger btn-sm icone" title="Supprimer" style="padding: 0.5rem 1rem;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#assignModal<?= $task['id'] ?>" style="padding: 0.5rem 1rem;">
                                        <i class="bi bi-person-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="kanban-column" ondragover="allowDrop(event)" ondrop="drop(event, 'doing')">
                <h5><span class="task-status bg-info badge">Doing</span></h5>
                <?php foreach ($tasks as $task): ?>
                    <?php if ($task['status'] === 'doing'): ?>
                        <div class="task" draggable="true" data-id="<?= $task['id']?>" ondragstart="drag(event)">
                            <div class="task-header">
                            <h4 class="task-title"><?= htmlspecialchars($task['title']) ?></h4>
                                <!-- <span class="badge bg-info"><?= htmlspecialchars($task['status']) ?></span> -->
                            </div>
                            <div class="task-body">
                                <p class="task-description"><em><?= htmlspecialchars($task['description']) ?></em></p>
                                <p class="card-text small mb-2">
                                    <i class="bi bi-calendar"></i> <?= isset($task['deadline']) && $task['deadline'] ? date('d/m/Y', strtotime($task['deadline'])) : 'Date non définie' ?>
                                </p>
                                <div class="mb-3">
                                    

                                    <!-- Modal -->
                                    <div class="modal fade" id="assignModal<?= $task['id'] ?>" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="assignModalLabel">Assigner à un membre</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <select class="form-select" id="assigned_to" name="assigned_to">
                                                        <option value="">Sélectionnez un membre</option>
                                                        <?php foreach ($members as $member): ?>
                                                            <option value="<?= $member['id'] ?>"><?= htmlspecialchars($member['name']) ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <button type="button" class="btn btn-primary">Assigner</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="task-footer">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="<?= base_url('projects/' . $project['id'] . '/tasks/' . $task['id'] . '/edit') ?>" class="btn btn-warning btn-sm icone" title="Modifier" style="padding: 0.5rem 1rem;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?= base_url('projects/' . $project['id'] . '/tasks/' . $task['id'] . '/delete') ?>" method="POST" style="display:inline;">
                                        <button type="submit" class="btn btn-danger btn-sm icone" title="Supprimer" style="padding: 0.5rem 1rem;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#assignModal<?= $task['id'] ?>" style="padding: 0.5rem 1rem;">
                                        <i class="bi bi-person-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="kanban-column" ondragover="allowDrop(event)" ondrop="drop(event, 'done')">
                <h5><span class="task-status bg-info badge">Done</span></h5>
                <?php foreach ($tasks as $task): ?>
                    <?php if ($task['status'] === 'done'): ?>
                        <div class="task" draggable="true" data-id="<?= $task['id']?>" ondragstart="drag(event)">
                            <div class="task-header">
                            <h4 class="task-title"><?= htmlspecialchars($task['title']) ?></h4>
                                <!-- <span class="badge bg-info"><?= htmlspecialchars($task['status']) ?></span> -->
                            </div>
                            <div class="task-body">
                                <p class="task-description"><em><?= htmlspecialchars($task['description']) ?></em></p>
                                <p class="card-text small mb-2">
                                    <i class="bi bi-calendar"></i> <?= isset($task['deadline']) && $task['deadline'] ? date('d/m/Y', strtotime($task['deadline'])) : 'Date non définie' ?>
                                </p>
                                <div class="mb-3">
                                    

                                    <!-- Modal -->
                                    <div class="modal fade" id="assignModal<?= $task['id'] ?>" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="assignModalLabel">Assigner à un membre</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <select class="form-select" id="assigned_to" name="assigned_to">
                                                        <option value="">Sélectionnez un membre</option>
                                                        <?php foreach ($members as $member): ?>
                                                            <option value="<?= $member['id'] ?>"><?= htmlspecialchars($member['name']) ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <button type="button" class="btn btn-primary">Assigner</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="task-footer">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="<?= base_url('projects/' . $project['id'] . '/tasks/' . $task['id'] . '/edit') ?>" class="btn btn-warning btn-sm icone" title="Modifier" style="padding: 0.5rem 1rem;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?= base_url('projects/' . $project['id'] . '/tasks/' . $task['id'] . '/delete') ?>" method="POST" style="display:inline;">
                                        <button type="submit" class="btn btn-danger btn-sm icone" title="Supprimer" style="padding: 0.5rem 1rem;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#assignModal<?= $task['id'] ?>" style="padding: 0.5rem 1rem;">
                                        <i class="bi bi-person-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <script>
        function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.dataset.id);
}

function drop(event, newStatus) {
    event.preventDefault();
    const taskId = event.dataTransfer.getData("text");
    console.log('Task ID:', taskId);
    updateTaskStatus(taskId, newStatus);
}

function updateTaskStatus(taskId, newStatus, projectId) {
    fetch(`/projects/${projectId}/tasks/${taskId}/update_status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log(data);
    })
    .catch(error => console.error('Error:', error));
}
    </script>