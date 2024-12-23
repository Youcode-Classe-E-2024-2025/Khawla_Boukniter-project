<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Gestionnaire de Projets' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= asset_url('css/style.css') ?>" rel="stylesheet">
    <link href="<?= asset_url('css/home.css') ?>" rel="stylesheet">
</head>
<body>
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
                    <?php if (is_authenticated()): ?>
                        <?php if (is_manager()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('projects') ?>">
                                    <i class="bi bi-folder me-1"></i>
                                    Mes Projets
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('tasks') ?>">
                                    <i class="bi bi-list-check me-1"></i>
                                    Mes Tâches
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#features">
                                <i class="bi bi-stars me-1"></i>
                                Fonctionnalités
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#projects">
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
                                <li><hr class="dropdown-divider"></li>
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

    <div class="container mt-4">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>
                <?= $_SESSION['error'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                <?= $_SESSION['success'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?= $content ?>
    </div>

    <?php if (!is_authenticated()): ?>
    <!-- <footer class="bg-light mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Gestionnaire de Projets</h5>
                    <p class="text-muted">
                        Une solution complète pour la gestion de vos projets et la collaboration d'équipe.
                    </p>
                </div>
                <div class="col-md-3">
                    <h5>Liens rapides</h5>
                    <ul class="list-unstyled">
                        <li><a href="#features" class="text-decoration-none">Fonctionnalités</a></li>
                        <li><a href="#projects" class="text-decoration-none">Projets Publics</a></li>
                        <li><a href="<?= base_url('register') ?>" class="text-decoration-none">S'inscrire</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Contact</h5>
                    <ul class="list-unstyled">
                        <li><a href="mailto:contact@example.com" class="text-decoration-none">contact@example.com</a></li>
                        <li>+1 234 567 890</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer> -->
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
