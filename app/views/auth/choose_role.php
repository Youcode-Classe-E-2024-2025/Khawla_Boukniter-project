<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Choisir votre rôle</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <strong>Important :</strong> Ce choix est définitif et déterminera votre rôle dans l'application.
                </div>

                <form action="/choose_role" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Chef de Projet</h5>
                                    <p class="card-text">
                                        En tant que chef de projet, vous pourrez :
                                    <ul>
                                        <li>Créer vos propres projets</li>
                                        <li>Gérer les tâches et les membres</li>
                                        <li>Suivre l'avancement des projets</li>
                                    </ul>
                                    </p>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="role" id="role_pm" value="manager" required>
                                        <label class="form-check-label" for="role_pm">
                                            Devenir Chef de Projet
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Membre</h5>
                                    <p class="card-text">
                                        En tant que membre, vous pourrez :
                                    <ul>
                                        <li>Rejoindre des projets existants</li>
                                        <li>Gérer vos tâches assignées</li>
                                        <li>Suivre votre progression</li>
                                    </ul>
                                    </p>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="role" id="role_member" value="member" required>
                                        <label class="form-check-label" for="role_member">
                                            Devenir Membre
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary btn-lg">Confirmer mon choix</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>