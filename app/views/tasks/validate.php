<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Valider la Tâche</h4>
            </div>
            <div class="card-body">
                <p>Êtes-vous sûr de vouloir valider cette tâche ?</p>
                <form action="<?= base_url('tasks/validate/' . $task['id']) ?>" method="POST">
                    <button type="submit" class="btn btn-success">Valider</button>
                    <a href="<?= base_url('tasks/view/' . $task['id']) ?>" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>
