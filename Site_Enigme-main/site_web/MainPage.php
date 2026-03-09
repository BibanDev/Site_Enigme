<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Enigme</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/theme.css">
    <style>
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: #f5f5f5;
            border-bottom: 2px solid #ddd;
        }
        
        .user-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .username-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .username-btn:hover {
            background-color: #45a049;
        }
        
        .logout-btn {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
        }
        
        .logout-btn:hover {
            background-color: #da190b;
        }
    </style>
</head>
<body>

    <div class="header">
        <div>
            <a href="classement.html">
                <button style="width:100px; height:50px;"><font size="2">Classement</button>
            </a>
        </div>
        
        <div class="user-section">
            <?php if (isset($_SESSION['username'])): ?>
                <span style="font-weight: bold;">👤 <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <a href="api/logout.php">
                    <button class="logout-btn">Déconnexion</button>
                </a>
            <?php else: ?>
                <a href="index.php">
                    <button style="width:200px; height:50px;"><font size="3">Se connecter</button>
                </a>
            <?php endif; ?>
        </div>
    </div>
    
    <hr>

    <h1 align="center">Ceci est le début du site d'énigmes</h1>

    <table width="100%" border="0">
        <tr>
            <td align="center">
            <a href="page_niveaux/page_niveau.php">               <!--lien niveaux-->
                <button style="width:200px; height:50px;"><font size="4">🎮 Niveaux</button>
            </a>
            <br><br>

            <a href="jouer.html">               <!--lien jouer-->
                <button style="width:200px; height:50px;"><font size="4">Jouer</button>
            </a>
            <br><br>

            <a href="settings.php">            <!--lien settings-->
                <button style="width:200px; height:50px;"><font size="4">Settings</button>
            </a>
            <br><br>

            <a href="credits.html">             <!--lien crédits-->
                <button style="width:200px; height:50px;"><font size="4">Crédits</button>
            </a>
            </td>
        </tr>
    </table> <!-- ensemble niveaux, jouer, settings, crédits-->

    <script src="js/theme.js"></script>
</body>
</html>