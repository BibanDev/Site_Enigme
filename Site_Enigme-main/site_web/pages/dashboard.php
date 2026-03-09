<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Énigme Game</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <div class="dashboard-container">
            <div class="header">
                <div class="user-info">
                    <h2>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?> ! 🎮</h2>
                    <p class="user-level">Niveau actuel: <strong><?php echo $_SESSION['niveau']; ?></strong></p>
                </div>
                <button class="logout-btn" onclick="deconnecter()">Se déconnecter</button>
            </div>

            <div class="content">
                <h3>🎯 Tableau de Bord</h3>
                <p>Bienvenue dans le jeu d'énigmes ! Vous êtes au niveau <strong><?php echo $_SESSION['niveau']; ?></strong>.</p>
                <p>C'est ici que vous pouvez commencer à résoudre des énigmes et aller plus loin dans le jeu.</p>
                <p style="margin-top: 20px; color: #999; font-size: 0.9em;">Prochaine étape : Ajouter les niveaux et les énigmes de votre jeu !</p>
            </div>
        </div>
    </div>

    <script>
        function deconnecter() {
            if (confirm("Êtes-vous sûr de vouloir vous déconnecter ?")) {
                window.location.href = '../api/logout.php';
            }
        }
    </script>
</body>
</html>
