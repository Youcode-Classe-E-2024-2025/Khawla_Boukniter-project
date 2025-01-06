    <footer class="footer mt-auto py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5 class="mb-3">ProjetManager</h5>
                    <p>Une solution simple et puissante pour la gestion de projets en équipe.</p>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Liens rapides</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?= base_url() ?>" class="text-decoration-none">Accueil</a></li>
                        <?php if (is_authenticated()): ?>
                            <li><a href="<?= base_url('dashboard') ?>" class="text-decoration-none">Tableau de bord</a></li>
                            <li><a href="<?= base_url('projects') ?>" class="text-decoration-none">Projets</a></li>
                        <?php else: ?>
                            <li><a href="<?= base_url('login') ?>" class="text-decoration-none">Connexion</a></li>
                            <li><a href="<?= base_url('register') ?>" class="text-decoration-none">Inscription</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Contact</h5>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-envelope me-2"></i>contact@projetmanager.com</li>
                        <li><i class="bi bi-telephone me-2"></i>+33 1 23 45 67 89</li>
                        <li><i class="bi bi-geo-alt me-2"></i>Paris, France</li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; <?= date('Y') ?> ProjetManager. Tous droits réservés.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <ul class="list-inline mb-0" style="text-align: center;">
                        <li class="list-inline-item">
                            <a href="#" class="text-decoration-none">
                                <i class="bi bi-facebook"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" class="text-decoration-none">
                                <i class="bi bi-twitter"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#" class="text-decoration-none">
                                <i class="bi bi-linkedin"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JavaScript -->
    <script src="<?= asset_url('js/main.js') ?>"></script>
    </body>

    </html>