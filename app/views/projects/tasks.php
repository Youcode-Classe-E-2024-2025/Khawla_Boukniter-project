<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tâches du Projet</title>
    <link rel="stylesheet" href="path/to/your/css/styles.css"> <!-- Mettez à jour le chemin vers votre CSS -->
</head>
<body>
    <h1>Tâches du Projet</h1>

    <form action="<?= base_url('tasks/create') ?>" method="POST">
        <label for="taskName">Nom de la Tâche :</label>
        <input type="text" id="taskName" name="taskName" required>

        <label for="taskDescription">Description :</label>
        <textarea id="taskDescription" name="taskDescription" required></textarea>

        <button type="submit">Créer Tâche</button>
    </form>

    <h2>Tâches Existantes</h2>
    <ul id="taskList">
        <?php foreach ($tasks as $task): ?>
            <li><?= htmlspecialchars($task['name']) ?> - <?= htmlspecialchars($task['description']) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
