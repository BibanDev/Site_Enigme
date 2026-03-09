<?php
header('Content-Type: application/json');
session_start();

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Non authentifié']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit();
}

require_once '../includes/config.php';

$niveau = isset($_POST['niveau']) ? intval($_POST['niveau']) : 0;

if ($niveau <= 0) {
    echo json_encode(['success' => false, 'message' => 'Niveau invalide']);
    exit();
}

$utilisateur_id = $_SESSION['utilisateur_id'];

// Récupérer le niveau actuel de l'utilisateur
$stmt = $connexion->prepare("SELECT niveau FROM utilisateurs WHERE id = ?");
$stmt->bind_param("i", $utilisateur_id);
$stmt->execute();
$resultat = $stmt->get_result();
$utilisateur = $resultat->fetch_assoc();
$niveau_actuel = $utilisateur['niveau'] ?? 1;

// Mettre à jour le niveau si le nouveau est supérieur
if ($niveau > $niveau_actuel) {
    $stmt = $connexion->prepare("UPDATE utilisateurs SET niveau = ? WHERE id = ?");
    $stmt->bind_param("ii", $niveau, $utilisateur_id);
    if ($stmt->execute()) {
        // Mettre à jour la session
        $_SESSION['niveau'] = $niveau;
        echo json_encode(['success' => true, 'message' => 'Progression synchronisée', 'ancien_niveau' => $niveau_actuel, 'nouveau_niveau' => $niveau]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => true, 'message' => 'Progression alignée', 'niveau' => $niveau_actuel]);
}

$connexion->close();
?>
