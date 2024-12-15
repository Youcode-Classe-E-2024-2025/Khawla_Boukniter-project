# Système de Gestion de Projets

Application de gestion de projets développée en PHP 8 avec architecture MVC.

## Structure du Projet
```
/
├── app/
│   ├── config/         # Configuration (DB, constantes)
│   ├── controllers/    # Contrôleurs
│   ├── models/        # Modèles
│   ├── views/         # Vues
│   └── core/          # Classes core (Router, Database, etc.)
├── public/            # Point d'entrée et assets publics
│   ├── css/
│   ├── js/
│   └── index.php
└── vendor/           # Dépendances (via Composer)
```

## Prérequis
- PHP 8.0 ou supérieur
- MySQL 5.7 ou supérieur
- Composer

## Installation
1. Cloner le repository
2. Exécuter `composer install`
3. Configurer la base de données dans `app/config/database.php`
4. Importer la structure de la base de données

## Fonctionnalités
### Utilisateur Non Connecté
- Voir les projets publics
- S'inscrire/Se connecter

### Chef de Projet
- Gestion complète des projets
- Gestion des tâches
- Gestion des catégories
- Gestion des membres
- Suivi de l'avancement

### Membre
- Rejoindre des projets
- Gérer ses tâches assignées
- Voir son tableau de bord
