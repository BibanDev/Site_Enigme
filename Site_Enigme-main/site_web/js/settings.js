// Variables globales
let darkModeToggle;

// Initialiser les éléments au chargement du DOM
document.addEventListener('DOMContentLoaded', function() {
    darkModeToggle = document.getElementById('darkModeToggle');
    
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', function() {
            this.classList.toggle('active');
        });
    }
    
    loadSettings();
});

// Charger les paramètres sauvegardés
function loadSettings() {
    fetch('api/get_settings.php')
        .then(response => response.json())
        .then(data => {
            if (data.darkMode) {
                enableDarkMode();
            } else {
                disableDarkMode();
            }

            const leaderboardToggle = document.getElementById('leaderboardToggle');
            if (leaderboardToggle) {
                leaderboardToggle.checked = data.enableLeaderboard !== false;
            }
        })
        .catch(error => console.error('Erreur chargement paramètres:', error));
}

function enableDarkMode() {
    document.documentElement.classList.add('dark-mode');
    if (darkModeToggle) {
        darkModeToggle.classList.add('active');
    }
}

function disableDarkMode() {
    document.documentElement.classList.remove('dark-mode');
    if (darkModeToggle) {
        darkModeToggle.classList.remove('active');
    }
}

// Sauvegarder les paramètres
function saveSettings() {
    const isDarkMode = darkModeToggle && darkModeToggle.classList.contains('active');
    const enableLeaderboard = document.getElementById('leaderboardToggle').checked;

    const settings = {
        darkMode: isDarkMode,
        enableLeaderboard: enableLeaderboard
    };

    fetch('api/save_settings.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(settings)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Afficher le message de succès
            const successMessage = document.getElementById('successMessage');
            successMessage.classList.add('show');
            setTimeout(() => {
                successMessage.classList.remove('show');
            }, 3000);

            console.log('Paramètres sauvegardés:', settings);
        }
    })
    .catch(error => console.error('Erreur sauvegarde paramètres:', error));
}

// Annuler et revenir aux paramètres actuels
function cancelSettings() {
    loadSettings();
    window.history.back();
}

