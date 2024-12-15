<?php

// Configuration de l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Chargement des helpers
require_once __DIR__ . '/../helpers/functions.php';

// Démarrage de la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
