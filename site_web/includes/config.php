<?php
// Configuration de la connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "";
$basedonnees = "enigme_game";

// Créer la connexion
$connexion = new mysqli($serveur, $utilisateur, $motdepasse, $basedonnees);

// Vérifier la connexion
if ($connexion->connect_error) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur de connexion à la base de données: ' . $connexion->connect_error]);
    exit();
}

// Définir le charset
$connexion->set_charset("utf8mb4");
?>
