<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/settings.css">
    <link rel="stylesheet" href="css/theme.css">
</head>
<body>
    <div class="settings-container">
        <h1>Settings</h1>
        
        <div class="success-message" id="successMessage">
            Paramètres sauvegardés avec succès !
        </div>

        <!-- Paramètres d'Affichage -->
        <div class="settings-group">
            <h3>Affichage</h3>
            
            <div class="setting-item">
                <label class="setting-label">Mode sombre</label>
                <div class="toggle-switch" id="darkModeToggle">
                    <div class="toggle-slider"></div>
                </div>
            </div>
        </div>

        <!-- Paramètres de Compte -->
        <div class="settings-group">
            <h3>Compte</h3>
            
            <div class="setting-item">
                <label class="setting-label">Participer aux classements</label>
                <input type="checkbox" class="checkbox-input" id="leaderboardToggle" checked>
            </div>
            <p style="font-size: 12px; margin: 10px 0 0 0; opacity: 0.7;">
                Décochez pour rester anonyme et ne pas apparaître dans les classements
            </p>
        </div>

        <!-- Boutons -->
        <div class="button-group">
            <button class="btn-save" onclick="saveSettings()">Enregistrer</button>
            <button class="btn-cancel" onclick="cancelSettings()">Annuler</button>
        </div>
    </div>

    <script src="js/theme.js"></script>
    <script src="js/settings.js"></script>
</body>
</html>
