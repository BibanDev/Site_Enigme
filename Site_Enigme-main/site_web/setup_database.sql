-- Créer la base de données
CREATE DATABASE IF NOT EXISTS enigme_game;
USE enigme_game;

-- Créer la table des utilisateurs
CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    niveau INT DEFAULT 1,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    derniere_connexion TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Créer la table des énigmes (optionnel, pour la suite)
CREATE TABLE IF NOT EXISTS enigmes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    niveau INT NOT NULL,
    titre VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    reponse VARCHAR(255) NOT NULL,
    indice TEXT,
    points INT DEFAULT 10,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Créer la table des progrès des utilisateurs (optionnel, pour tracker qui a résolu quoi)
CREATE TABLE IF NOT EXISTS progres_utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    enigme_id INT NOT NULL,
    resolu BOOLEAN DEFAULT FALSE,
    date_resolution TIMESTAMP NULL,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (enigme_id) REFERENCES enigmes(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_enigme (utilisateur_id, enigme_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
