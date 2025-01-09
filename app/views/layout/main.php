<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle . ' - ' : '' ?>Gestionnaire de Projets</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="<?= asset_url('css/style.css') ?>" rel="stylesheet">
    <?php if (isset($isHomePage) && $isHomePage): ?>
        <link href="<?= asset_url('css/home.css') ?>" rel="stylesheet">
    <?php endif; ?>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="bi bi-kanban me-2"></i>
                Gestionnaire de Projets
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <?php if (!is_authenticated()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('projects') ?>/#projects">
                                <i class="bi bi-collection me-1"></i>
                                Projets Publics
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav">
                    <?php if (is_authenticated()): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>
                                <?= htmlspecialchars(user_name()) ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('profile') ?>">
                                        <i class="bi bi-person me-2"></i>
                                        Mon Profil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('dashboard') ?>">
                                        <i class="bi bi-grid me-2"></i>
                                        Tableau de Bord
                                    </a>
                                </li>
                                    <li class="nav-item">
                                        <a class="dropdown-item" href="<?= base_url('projects') ?>">
                                            <i class="bi bi-folder me-1"></i>
                                            Mes Projets
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="dropdown-item" href="<?= base_url('tasks') ?>">
                                            <i class="bi bi-list-check me-1"></i>
                                            Mes Tâches
                                        </a>
                                    </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                                        <i class="bi bi-box-arrow-right me-2"></i>
                                        Déconnexion
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('login') ?>">
                                <i class="bi bi-box-arrow-in-right me-1"></i>
                                Connexion
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary ms-2" href="<?= base_url('register') ?>">
                                <i class="bi bi-person-plus me-1"></i>
                                S'inscrire
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['error'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Contenu de la page -->
    <main class="container mt-4">
        <?= $content ?>
    </main>

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