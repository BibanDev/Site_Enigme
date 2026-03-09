<?php
// Démarrer la session si pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fonction pour vérifier si l'utilisateur est connecté
function estConnecte() {
    return isset($_SESSION['utilisateur_id']);
}

// Fonction pour rediriger vers la page de connexion si pas connecté
function verifierConnexion() {
    if (!estConnecte()) {
        header("Location: index.php");
        exit();
    }
}

// Fonction pour obtenir les informations de l'utilisateur
function obtenirUtilisateur($connexion, $id) {
    $stmt = $connexion->prepare("SELECT id, username, niveau FROM utilisateurs WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultat = $stmt->get_result();
    return $resultat->fetch_assoc();
}

// Fonction pour déconnexion
function deconnecter() {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>
