// Alterner entre les formulaires de connexion et inscription
function toggleForms(event) {
    event.preventDefault();
    
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    
    loginForm.classList.toggle('active');
    registerForm.classList.toggle('active');
    
    // Réinitialiser les messages d'erreur
    clearErrors();
}

// Effacer les messages d'erreur
function clearErrors() {
    document.getElementById('loginError').classList.remove('show');
    document.getElementById('registerError').classList.remove('show');
    document.getElementById('registerSuccess').classList.remove('show');
}

// Formulaire de connexion
document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const username = document.getElementById('login-username').value;
    const password = document.getElementById('login-password').value;
    const errorDiv = document.getElementById('loginError');
    
    try {
        const response = await fetch('api/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Synchroniser les niveaux locaux avec la base de données
            const niveauxLocaux = localStorage.getItem('niveaux_joues');
            if (niveauxLocaux) {
                const niveaux = JSON.parse(niveauxLocaux);
                if (niveaux.length > 0) {
                    const maxNiveau = Math.max(...niveaux);
                    try {
                        await fetch('api/sync_progression.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `niveau=${encodeURIComponent(maxNiveau)}`
                        });
                        // Nettoyer le localStorage après synchronisation
                        localStorage.removeItem('niveaux_joues');
                    } catch (syncError) {
                        console.warn('Erreur lors de la synchronisation:', syncError);
                    }
                }
            }
            
            // Rediriger vers la page principale
            window.location.href = 'MainPage.php';
        } else {
            errorDiv.textContent = data.message || 'Erreur lors de la connexion';
            errorDiv.classList.add('show');
        }
    } catch (error) {
        errorDiv.textContent = 'Erreur de réseau: ' + error.message;
        errorDiv.classList.add('show');
    }
});

// Formulaire d'inscription
document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const username = document.getElementById('register-username').value;
    const password = document.getElementById('register-password').value;
    const passwordConfirm = document.getElementById('register-password-confirm').value;
    const errorDiv = document.getElementById('registerError');
    const successDiv = document.getElementById('registerSuccess');
    
    // Validation locale
    if (password !== passwordConfirm) {
        errorDiv.textContent = 'Les mots de passe ne correspondent pas';
        errorDiv.classList.add('show');
        successDiv.classList.remove('show');
        return;
    }
    
    if (username.length < 3) {
        errorDiv.textContent = 'Le nom d\'utilisateur doit contenir au moins 3 caractères';
        errorDiv.classList.add('show');
        successDiv.classList.remove('show');
        return;
    }
    
    if (password.length < 6) {
        errorDiv.textContent = 'Le mot de passe doit contenir au moins 6 caractères';
        errorDiv.classList.add('show');
        successDiv.classList.remove('show');
        return;
    }
    
    try {
        const response = await fetch('api/register.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
        });
        
        const data = await response.json();
        
        if (data.success) {
            successDiv.textContent = 'Compte créé avec succès! Vous pouvez maintenant vous connecter.';
            successDiv.classList.add('show');
            errorDiv.classList.remove('show');
            
            // Réinitialiser le formulaire
            document.getElementById('registerForm').reset();
            
            // Basculer vers le formulaire de connexion après 2 secondes
            setTimeout(() => {
                document.getElementById('loginForm').classList.add('active');
                document.getElementById('registerForm').classList.remove('active');
                document.getElementById('login-username').value = username;
                clearErrors();
            }, 2000);
        } else {
            errorDiv.textContent = data.message || 'Erreur lors de l\'inscription';
            errorDiv.classList.add('show');
            successDiv.classList.remove('show');
        }
    } catch (error) {
        errorDiv.textContent = 'Erreur de réseau: ' + error.message;
        errorDiv.classList.add('show');
        successDiv.classList.remove('show');
    }
});
