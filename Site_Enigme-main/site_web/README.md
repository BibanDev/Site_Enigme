# 🎯 Énigme Game - Site Web

Un site de jeu d'énigmes complet avec système d'authentification et progression des niveaux.

## 📋 Installation

### 1. Préparation de XAMPP

- Démarrer Apache et MySQL dans XAMPP Control Panel
- S'assurer que MySQL est configuré (par défaut: utilisateur `root`, pas de mot de passe)

### 2. Créer la base de données

**Option A: Via PhpMyAdmin**
- Ouvrir [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
- Créer une nouvelle base de données nommée `enigme_game`
- Importer le fichier `setup_database.sql`:
  - Sélectionner la base de données
  - Aller dans l'onglet "Importer"
  - Choisir le fichier `setup_database.sql`
  - Cliquer sur "Exécuter"

**Option B: Via Terminal**
```bash
mysql -u root < setup_database.sql
```

### 3. Placer les fichiers

- Copier le dossier `site_web` dans le dossier `htdocs` de XAMPP
  - Chemin: `C:\xampp\htdocs\site_web`

### 4. Accéder à l'application

- Ouvrir le navigateur et aller à: [http://localhost/site_web](http://localhost/site_web)

## 📁 Structure du projet

```
site_web/
├── index.php              # Page principale (connexion/inscription)
├── api/
│   ├── login.php          # API de connexion
│   ├── register.php       # API d'inscription
│   └── logout.php         # Déconnexion
├── pages/
│   └── dashboard.php      # Tableau de bord utilisateur
├── includes/
│   ├── config.php         # Configuration de la base de données
│   └── functions.php      # Fonctions utilitaires
├── css/
│   └── styles.css         # Tous les styles CSS
├── js/
│   └── auth.js            # JavaScript pour l'authentification
└── setup_database.sql     # Script SQL pour créer la BD
```

## 🔐 Fonctionnalités

### Authentification
- Inscription avec validation
- Connexion sécurisée (mots de passe hashés avec bcrypt)
- Gestion des sessions

### Utilisateurs
- Nom d'utilisateur (username)
- Mot de passe sécurisé
- Niveau actuel de progression

### Base de données
Tables incluses:
- `utilisateurs`: Stockage des comptes
- `enigmes`: Stockage des énigmes (prêt pour la phase 2)
- `progres_utilisateurs`: Suivi de la progression (prêt pour la phase 2)

## 🚀 Étapes futures

1. **Créer les énigmes**: Ajouter des énigmes dans la table `enigmes`
2. **Jeu**: Développer la page de jeu avec système de vérification des réponses
3. **Leaderboards**: Ajouter un classement global
4. **Profil utilisateur**: Page de profil avec historique
5. **Admin panel**: Interface de gestion des énigmes

## 🔒 Notes de sécurité

- Les mots de passe sont hashés avec bcrypt
- Utilisation de prepared statements pour éviter les injections SQL
- Validation des données côté serveur
- Sessions PHP sécurisées

## 📝 Identifiants par défaut

Aucun compte n'est créé par défaut. Créez votre compte lors de votre première visite !

---

Développé avec ❤️ pour les amateurs d'énigmes
