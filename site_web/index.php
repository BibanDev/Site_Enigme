<?php
session_start();

// Si l'utilisateur est connecté, le rediriger vers la page principale
if (isset($_SESSION['utilisateur_id'])) {
    header("Location: MainPage.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Énigme Game - Connexion</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <div class="auth-wrapper">
            <div class="auth-container">
                <h1 class="title">🎯 Énigme Game</h1>
                <p class="subtitle">Bienvenue dans le monde des énigmes</p>

                <!-- Formulaire de connexion -->
                <form id="loginForm" class="auth-form active">
                    <h2>Connexion</h2>
                    
                    <div class="form-group">
                        <label for="login-username">Nom d'utilisateur</label>
                        <input type="text" id="login-username" name="username" required>
                    </div>

                    <div class="form-group">
                        <label for="login-password">Mot de passe</label>
                        <input type="password" id="login-password" name="password" required>
                    </div>

                    <div id="loginError" class="error-message"></div>

                    <button type="submit" class="btn btn-primary">Se connecter</button>

                    <p class="toggle-text">Pas encore inscrit ? <a href="#" onclick="toggleForms(event)">Créer un compte</a></p>
                </form>

                <!-- Formulaire d'inscription -->
                <form id="registerForm" class="auth-form">
                    <h2>Créer un compte</h2>

                    <div class="form-group">
                        <label for="register-username">Nom d'utilisateur</label>
                        <input type="text" id="register-username" name="username" required minlength="3" maxlength="20">
                        <small>3 à 20 caractères</small>
                    </div>

                    <div class="form-group">
                        <label for="register-password">Mot de passe</label>
                        <input type="password" id="register-password" name="password" required minlength="6">
                        <small>Au moins 6 caractères</small>
                    </div>

                    <div class="form-group">
                        <label for="register-password-confirm">Confirmer le mot de passe</label>
                        <input type="password" id="register-password-confirm" name="password_confirm" required>
                    </div>

                    <div id="registerError" class="error-message"></div>
                    <div id="registerSuccess" class="success-message"></div>

                    <button type="submit" class="btn btn-primary">Créer un compte</button>

                    <p class="toggle-text">Déjà inscrit ? <a href="#" onclick="toggleForms(event)">Se connecter</a></p>
                </form>
            </div>
        </div>
    </div>

    <script src="js/auth.js"></script>
</body>
</html>
