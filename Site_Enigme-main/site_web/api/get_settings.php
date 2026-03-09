<?php
session_start();
header('Content-Type: application/json');

$darkMode = isset($_SESSION['darkMode']) ? $_SESSION['darkMode'] : false;
$enableLeaderboard = isset($_SESSION['enableLeaderboard']) ? $_SESSION['enableLeaderboard'] : true;

echo json_encode([
    'darkMode' => $darkMode,
    'enableLeaderboard' => $enableLeaderboard
]);
?>
