// Sélection des éléments
const loginForm = document.getElementById('loginForm');
const usernameInput = document.getElementById('username');
const passwordInput = document.getElementById('password');
const togglePasswordBtn = document.getElementById('togglePassword');
const formMessage = document.getElementById('formMessage');

// Toggle Password Visibility
togglePasswordBtn.addEventListener('click', (e) => {
    e.preventDefault();
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    
    // Change l'emoji
    const eyeIcon = togglePasswordBtn.querySelector('.eye-icon');
    eyeIcon.textContent = type === 'password' ? '👁️' : '👁️‍🗨️';
});

// Validation du formulaire
function validateForm() {
    let isValid = true;
    
    // Validation username
    const usernameError = document.getElementById('usernameError');
    if (usernameInput.value.trim().length < 3) {
        usernameError.textContent = 'Le nom d\'utilisateur doit contenir au moins 3 caractères';
        usernameError.classList.add('show');
        isValid = false;
    } else {
        usernameError.classList.remove('show');
    }
    
    // Validation password
    const passwordError = document.getElementById('passwordError');
    if (passwordInput.value.length < 6) {
        passwordError.textContent = 'Le mot de passe doit contenir au moins 6 caractères';
        passwordError.classList.add('show');
        isValid = false;
    } else {
        passwordError.classList.remove('show');
    }
    
    return isValid;
}

// Validation en temps réel
usernameInput.addEventListener('blur', () => {
    const usernameError = document.getElementById('usernameError');
    if (usernameInput.value.trim().length > 0 && usernameInput.value.trim().length < 3) {
        usernameError.textContent = 'Le nom d\'utilisateur doit contenir au moins 3 caractères';
        usernameError.classList.add('show');
    } else {
        usernameError.classList.remove('show');
    }
});

passwordInput.addEventListener('blur', () => {
    const passwordError = document.getElementById('passwordError');
    if (passwordInput.value.length > 0 && passwordInput.value.length < 6) {
        passwordError.textContent = 'Le mot de passe doit contenir au moins 6 caractères';
        passwordError.classList.add('show');
    } else {
        passwordError.classList.remove('show');
    }
});

// Soumission du formulaire
loginForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    // Validation client
    if (!validateForm()) {
        showMessage('Veuillez corriger les erreurs avant de continuer', 'error');
        return;
    }
    
    // Affiche le loading
    const submitBtn = loginForm.querySelector('.btn-login');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    showMessage('Vérification de vos identifiants...', 'loading');
    
    try {
        // Envoi des données au serveur
        const formData = new FormData(loginForm);
        
        const response = await fetch('php/login.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            showMessage('Connexion réussie ! Redirection en cours...', 'success');
            setTimeout(() => {
                window.location.href = 'enigmes.html';
            }, 1500);
        } else {
            showMessage(data.message || 'Nom d\'utilisateur ou mot de passe incorrect', 'error');
            submitBtn.disabled = false;
        }
    } catch (error) {
        console.error('Erreur:', error);
        showMessage('Une erreur s\'est produite. Veuillez réessayer.', 'error');
        submitBtn.disabled = false;
    }
});

// Affiche les messages
function showMessage(message, type) {
    formMessage.textContent = message;
    formMessage.classList.remove('error', 'success', 'loading');
    formMessage.classList.add(type);
    
    if (type === 'loading') {
        const spinner = document.createElement('span');
        spinner.className = 'spinner';
        formMessage.innerHTML = `<span class="spinner"></span>${message}`;
    }
}

// Clear message au focus des inputs
usernameInput.addEventListener('focus', () => {
    formMessage.classList.remove('error', 'success', 'loading');
    formMessage.textContent = '';
});

passwordInput.addEventListener('focus', () => {
    formMessage.classList.remove('error', 'success', 'loading');
    formMessage.textContent = '';
});
