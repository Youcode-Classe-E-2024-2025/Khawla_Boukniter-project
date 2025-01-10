# Khawla Boukniter Project

## Description
Ce projet est une application de gestion de tâches qui permet aux utilisateurs de créer, gérer et assigner des tâches au sein de projets.

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

## Fonctionnalités
- **Création et gestion de projets** : Les utilisateurs peuvent créer de nouveaux projets et gérer les tâches associées.
- **Assignation de tâches** : Les chefs de projet peuvent assigner des tâches à des membres spécifiques. Si un utilisateur qui n'est pas le chef de projet ou le créateur du projet tente d'accéder à un projet, il sera redirigé vers une page 404.
- **Affichage des tâches** : Les tâches sont affichées selon leur statut (À faire, En cours, Terminé) et l'utilisateur assigné.
- **Permissions** : Les permissions des membres sont affichées sous forme de badges sur la page des projets.
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

## Installation
1. Clonez le dépôt :
   ```bash
   git clone https://github.com/votre-utilisateur/votre-repo.git
   ```
2. Installez les dépendances :
   ```bash
   composer install
   ```
3. Configurez votre base de données dans le fichier `.env`.

## Utilisation
- Pour démarrer le serveur, utilisez la commande suivante :
   ```bash
   php -S localhost:8000 -t public
   ```
