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

if (strlen($username) < 3 || strlen($username) > 20) {
    echo json_encode(['success' => false, 'message' => 'Le nom d\'utilisateur doit contenir entre 3 et 20 caractères']);
    exit();
}

if (strlen($password) < 6) {
    echo json_encode(['success' => false, 'message' => 'Le mot de passe doit contenir au moins 6 caractères']);
    exit();
}

// Vérifier si l'utilisateur existe déjà
$stmt = $connexion->prepare("SELECT id FROM utilisateurs WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$resultat = $stmt->get_result();

if ($resultat->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Ce nom d\'utilisateur est déjà pris']);
    $stmt->close();
    $connexion->close();
    exit();
}

$stmt->close();

// Hasher le mot de passe
$password_hash = password_hash($password, PASSWORD_BCRYPT);

// Insérer le nouvel utilisateur
$stmt = $connexion->prepare("INSERT INTO utilisateurs (username, password, niveau) VALUES (?, ?, ?)");
$niveau_initial = 1;
$stmt->bind_param("ssi", $username, $password_hash, $niveau_initial);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Compte créé avec succès']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la création du compte']);
}

$stmt->close();
$connexion->close();
?>
