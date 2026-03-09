// Appliquer le mode sombre global sur toutes les pages
function applyTheme() {
    fetch('api/get_settings.php')
        .then(response => response.json())
        .then(data => {
            if (data.darkMode) {
                document.documentElement.classList.add('dark-mode');
            } else {
                document.documentElement.classList.remove('dark-mode');
            }
        })
        .catch(error => console.error('Erreur chargement thème:', error));
}

// Appliquer le thème au chargement
document.addEventListener('DOMContentLoaded', applyTheme);
