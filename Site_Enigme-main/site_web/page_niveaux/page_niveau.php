<?php
session_start();

require_once '../includes/config.php';

// Déterminer le niveau de l'utilisateur
$niveau_debloque = 1;
$total_niveaux = 6;
$est_connecte = isset($_SESSION['utilisateur_id']);

if ($est_connecte) {
    // Récupérer le niveau depuis la base de données
    $utilisateur_id = $_SESSION['utilisateur_id'];
    $stmt = $connexion->prepare("SELECT niveau FROM utilisateurs WHERE id = ?");
    $stmt->bind_param("i", $utilisateur_id);
    $stmt->execute();
    $resultat = $stmt->get_result();
    $utilisateur = $resultat->fetch_assoc();
    $niveau_debloque = $utilisateur['niveau'] ?? 1;
    $stmt->close();
}

$connexion->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Les Niveaux</title>
    <link rel="stylesheet" href="titre_style.css"> 
</head>
    <style>
        <!---la claase des niveau --->

        h1 {
            margin-top: 40px;
        }

        .container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 50px;
        }

        .niveau {
            width: 1000px;
            height: 120px;
            margin: 20px;
            border-radius: 20px;
            display: flex;
            justify-content: left;
            align-items: center;
            font-size: 25px;
            font-weight: bold;
            text-decoration: none;
            transition: 0.3s;
        }

        .accessible {
            background-color: #e87979f6;
            color: black;
        }

        .accessible:hover {
            background-color: #a72e1e;
            transform: scale(1.2);
        }

        .verrouille {
            background-color: #555;
            cursor: not-allowed;
            position: relative;
        }

        .verrouille::after {
            content: "🔒";
            position: absolute;
            right: 10px;
            font-size: 48px;
        }
    </style>
</head>
<body>

<h1>Les Niveaux</h1>

<?php if (!$est_connecte): ?>
    <div style="background-color: #fff3cd; border: 1px solid #ffc107; border-radius: 5px; padding: 15px; margin: 20px; text-align: center; color: #856404;">
        <strong>⚠️ Mode Invité :</strong> Vos progrès seront sauvegardés temporarily. <a href="../index.php" style="color: #856404; text-decoration: underline;">Connectez-vous</a> pour sauvegarder vos progrès de manière permanente.
    </div>
<?php else: ?>
    <div style="text-align: center; margin: 20px; color: #28a745;">
        <strong>✅ Connecté</strong> - Vos progrès sont sauvegardés automatiquement
    </div>
<?php endif; ?>
<div class="container">
    <?php
    for ($i = 1; $i <= $total_niveaux; $i++) {
        $data_level = "data-level=\"$i\"";
        $debloque = $i <= $niveau_debloque ? 'true' : 'false';
        $data_debloque = "data-debloque=\"$debloque\"";
        
        if ($i <= $niveau_debloque || (!$est_connecte && $i == 1)) {
            echo "<a href='niveau$i.php' class='niveau accessible' $data_level $data_debloque> ㅤㅤㅤNiveau $i : </a>";
        } else {
            echo "<div class='niveau verrouille' $data_level $data_debloque> ㅤㅤㅤNiveau $i : </div>";
        }
    }
    ?>
</div>

<script>
// Gérer la progression en mode invité avec localStorage
const estConnecte = <?php echo json_encode($est_connecte); ?>;

function getNiveauxLocaux() {
    const niveaux = localStorage.getItem('niveaux_joues');
    return niveaux ? JSON.parse(niveaux) : [];
}

function sauvegarderNiveauLocal(numeroNiveau) {
    if (!estConnecte) {
        let niveaux = getNiveauxLocaux();
        if (!niveaux.includes(numeroNiveau)) {
            niveaux.push(numeroNiveau);
            niveaux.sort((a, b) => a - b);
            localStorage.setItem('niveaux_joues', JSON.stringify(niveaux));
        }
    }
}

// Initialiser les niveaux locaux au chargement
window.addEventListener('DOMContentLoaded', function() {
    if (!estConnecte) {
        const niveaux = getNiveauxLocaux();
        const maxNiveau = niveaux.length > 0 ? Math.max(...niveaux) : 0;
        
        // Déverrouiller les niveaux joués localement
        document.querySelectorAll('.niveau[data-debloque="false"]').forEach(el => {
            const niveau = parseInt(el.getAttribute('data-level'));
            if (niveau <= maxNiveau + 1) {
                if (!el.classList.contains('accessible')) {
                    el.classList.remove('verrouille');
                    el.classList.add('accessible');
                    if (el.tagName === 'DIV') {
                        const lien = document.createElement('a');
                        lien.href = 'niveau' + niveau + '.php';
                        lien.className = 'niveau accessible';
                        lien.setAttribute('data-level', niveau);
                        lien.setAttribute('data-debloque', 'true');
                        lien.textContent = el.textContent;
                        el.parentNode.replaceChild(lien, el);
                    }
                }
            }
        });
    }
});

// Écouter les clics sur les niveaux pour sauvegarder la progression locale
document.querySelectorAll('.niveau.accessible').forEach(niveau => {
    niveau.addEventListener('click', function() {
        const numeroNiveau = parseInt(this.getAttribute('data-level'));
        if (!isNaN(numeroNiveau)) {
            sauvegarderNiveauLocal(numeroNiveau);
        }
    });
});
</script>

</body>
</html>


