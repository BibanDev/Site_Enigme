<?php
header('Content-Type: application/json');
session_start();

require_once '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit();
}

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Validation
if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Veuillez remplir tous les champs']);
    exit();
}

// Préparer la requête pour éviter les injections SQL
$stmt = $connexion->prepare("SELECT id, username, password, niveau FROM utilisateurs WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$resultat = $stmt->get_result();

if ($resultat->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Nom d\'utilisateur ou mot de passe incorrect']);
    exit();
}

$utilisateur = $resultat->fetch_assoc();

// Vérifier le mot de passe
if (password_verify($password, $utilisateur['password'])) {
    // Créer les variables de session
    $_SESSION['utilisateur_id'] = $utilisateur['id'];
    $_SESSION['username'] = $utilisateur['username'];
    $_SESSION['niveau'] = $utilisateur['niveau'];
    
    echo json_encode(['success' => true, 'message' => 'Connexion réussie']);
} else {
    echo json_encode(['success' => false, 'message' => 'Nom d\'utilisateur ou mot de passe incorrect']);
}

$stmt->close();
$connexion->close();
?>
