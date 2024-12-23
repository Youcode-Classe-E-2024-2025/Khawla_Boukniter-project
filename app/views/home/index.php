
<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold">Gérez vos projets efficacement</h1>
                <p class="lead">Une solution simple et puissante pour la gestion de projets en équipe. Collaborez, suivez et réussissez ensemble.</p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                    <a href="<?= base_url('register') ?>" class="btn btn-light btn-lg px-4 me-md-2">Commencer gratuitement</a>
                    <a href="<?= base_url('login') ?>" class="btn btn-outline-light btn-lg px-4">Se connecter</a>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <img src="<?= asset_url('img/hero-illustration.svg') ?>" alt="Illustration" class="img-fluid">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-kanban"></i>
                    </div>
                    <h3>Gestion de Projets</h3>
                    <p>Créez et gérez vos projets avec une interface intuitive. Suivez l'avancement en temps réel.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h3>Collaboration</h3>
                    <p>Travaillez en équipe efficacement. Partagez des tâches et communiquez facilement.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <h3>Suivi & Statistiques</h3>
                    <p>Visualisez la progression de vos projets avec des graphiques et statistiques détaillés.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Projects Section -->
<section class="projects">
    <div class="container">
        <h2 class="text-center mb-5">Projets Publics Récents</h2>
        <div class="row g-4">
            <?php foreach ($projects as $project): ?>
            <div class="col-md-4">
                <div class="card project-card h-100">
                    <div class="card-body">
                        <h5 class="card-title gradient-text fw-bold"><?= escape_html($project['title']) ?></h5>
                        <p class="card-text"><?= escape_html($project['description']) ?></p>
                        <div class="project-meta">
                            <span><i class="bi bi-calendar"></i> <?= format_date($project['created_at']) ?></span>
                            <span><i class="bi bi-person"></i> <?= escape_html($project['manager_name']) ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Stats Section -->
<!-- <section class="stats">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <h3><?= $stats['total_projects'] ?></h3>
                    <p>Projets Actifs</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h3><?= $stats['total_users'] ?></h3>
                    <p>Utilisateurs</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <h3><?= $stats['completed_tasks'] ?></h3>
                    <p>Tâches Complétées</p>
                </div>
            </div>
        </div>
    </div>
</section> -->

<!-- CTA Section -->
<section class="cta">
    <div class="container">
        <h2>Prêt à commencer ?</h2>
        <p>Rejoignez des milliers d'équipes qui utilisent notre plateforme pour réussir leurs projets.</p>
        <a href="<?= base_url('register') ?>" class="btn btn-light btn-lg">Créer un compte gratuitement</a>
    </div>
</section>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>
