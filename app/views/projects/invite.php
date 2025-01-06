<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Inviter un Membre au Projet</h4>
            </div>
            <div class="card-body">
                <form action="<?= base_url("projects/" . $projectId . "/invite") ?>" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Envoyer l'Invitation</button>
                </form>
            </div>
        </div>
    </div>
</div>