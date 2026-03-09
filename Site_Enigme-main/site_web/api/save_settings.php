<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['darkMode'])) {
        $_SESSION['darkMode'] = $data['darkMode'] === 'true' || $data['darkMode'] === true;
    }

    if (isset($data['enableLeaderboard'])) {
        $_SESSION['enableLeaderboard'] = $data['enableLeaderboard'] === 'true' || $data['enableLeaderboard'] === true;
    }

    echo json_encode([
        'success' => true,
        'message' => 'Paramètres sauvegardés',
        'darkMode' => $_SESSION['darkMode'] ?? false,
        'enableLeaderboard' => $_SESSION['enableLeaderboard'] ?? true
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Méthode non autorisée'
    ]);
}
?>
