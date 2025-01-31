-- Création du schéma si nécessaire
CREATE SCHEMA IF NOT EXISTS `EduCompare`;
USE `EduCompare`;

-- Création de la table Utilisateur
CREATE TABLE IF NOT EXISTS `Utilisateur` (
    `idUtilisateur` INT AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(100) NOT NULL,
    `prenom` VARCHAR(100) NOT NULL,
    `username` VARCHAR(100) NOT NULL UNIQUE,
    `motDePasse` VARCHAR(255) NOT NULL,
    `situation` ENUM('Admin', 'Etudiant', 'Parent') NOT NULL
);

-- Création de la table Formation
CREATE TABLE IF NOT EXISTS `Formation` (
    `idFormation` INT AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(200) NOT NULL,
    `description` TEXT NOT NULL,
    `prix` DECIMAL(10, 2) NOT NULL,
    `typeEcole` ENUM('Privee', 'Publique') NOT NULL,
    `uniforme` BOOLEAN NOT NULL,
    `internat` BOOLEAN NOT NULL,
    `tauxReussite` DECIMAL(5, 2) NOT NULL,
    `logo` LONGBLOB,
    `pays` VARCHAR(50)
);

-- Création de la table Langue
CREATE TABLE IF NOT EXISTS `Langue` (
    `idLangue` INT AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(100) NOT NULL UNIQUE
);

-- Création de la table d'association Formation_Langue
CREATE TABLE IF NOT EXISTS `Formation_Langue` (
    `idFormation` INT NOT NULL,
    `idLangue` INT NOT NULL,
    PRIMARY KEY (`idFormation`, `idLangue`),
    FOREIGN KEY (`idFormation`) REFERENCES `Formation`(`idFormation`) ON DELETE CASCADE,
    FOREIGN KEY (`idLangue`) REFERENCES `Langue`(`idLangue`) ON DELETE CASCADE
);

-- Création de la table Recherche
CREATE TABLE IF NOT EXISTS `Recherche` (
    `idRecherche` INT AUTO_INCREMENT PRIMARY KEY,
    `idUtilisateur` INT NOT NULL,
    `dateRecherche` DATE NOT NULL,
    FOREIGN KEY (`idUtilisateur`) REFERENCES `Utilisateur`(`idUtilisateur`) ON DELETE CASCADE
);

-- Création de la table CritereRecherche
CREATE TABLE IF NOT EXISTS `CritereRecherche` (
    `idCritere` INT AUTO_INCREMENT PRIMARY KEY,
    `idRecherche` INT NOT NULL,
    `diplomeObtenu` VARCHAR(100) NOT NULL,
    `prixMax` DECIMAL(10, 2) NOT NULL,
    `typeEcole` ENUM('Privee', 'Publique'),
    `langues` VARCHAR(200),
    `uniforme` BOOLEAN,
    `internat` BOOLEAN,
    `tauxReussiteMin` DECIMAL(5, 2),
    FOREIGN KEY (`idRecherche`) REFERENCES `Recherche`(`idRecherche`) ON DELETE CASCADE
);

-- Création de la table Correspondance
CREATE TABLE IF NOT EXISTS `Correspondance` (
    `idFormation` INT NOT NULL,
    `idCritere` INT NOT NULL,
    PRIMARY KEY (`idFormation`, `idCritere`),
    FOREIGN KEY (`idFormation`) REFERENCES `Formation`(`idFormation`) ON DELETE CASCADE,
    FOREIGN KEY (`idCritere`) REFERENCES `CritereRecherche`(`idCritere`) ON DELETE CASCADE
);

-- Insertion de données dans la table Utilisateur
INSERT INTO `Utilisateur` (`nom`, `prenom`, `username`, `motDePasse`, `situation`) VALUES
('Admin', 'Principal', 'admin01', 'adminpassword', 'Admin'),
('Dupont', 'Jean', 'jean.dupont', 'password123', 'Etudiant'),
('Martin', 'Sophie', 'sophie.martin', 'password456', 'Parent');

-- Insertion de données dans la table Formation
INSERT INTO `Formation` (`nom`, `description`, `prix`, `typeEcole`, `uniforme`, `internat`, `tauxReussite`) VALUES
('Lycée Privé Saint-Exupéry', 'Un lycée réputé pour ses excellents résultats.', 1500.00, 'Privee', TRUE, TRUE, 98.5),
('Lycée Public Victor Hugo', 'Un établissement public offrant des formations variées.', 0.00, 'Publique', FALSE, FALSE, 85.0),
('École de Commerce XYZ', 'Formation spécialisée en management et commerce international.', 8000.00, 'Privee', FALSE, TRUE, 90.0),
('École d\'Art Moderne', 'Programme dédié aux arts visuels et au design.', 2000.00, 'Privee', FALSE, FALSE, 88.0);

-- Insertion des langues dans la table Langue
INSERT INTO `Langue` (`nom`) VALUES
('Français'),
('Anglais'),
('Italien');

-- Insertion des associations de langues avec les formations
INSERT INTO `Formation_Langue` (`idFormation`, `idLangue`) VALUES
(1, 1),  -- Lycée Privé Saint-Exupéry - Français
(1, 2),  -- Lycée Privé Saint-Exupéry - Anglais
(2, 1),  -- Lycée Public Victor Hugo - Français
(3, 2),  -- École de Commerce XYZ - Anglais
(4, 1),  -- École d'Art Moderne - Français
(4, 3);  -- École d'Art Moderne - Italien

-- Insertion de données dans la table Recherche
INSERT INTO `Recherche` (`idUtilisateur`, `dateRecherche`) VALUES
(2, '2025-01-01'),
(3, '2025-01-02');

-- Insertion de données dans la table CritereRecherche
INSERT INTO `CritereRecherche` (`idRecherche`, `diplomeObtenu`, `prixMax`, `typeEcole`, `langues`, `uniforme`, `internat`, `tauxReussiteMin`) VALUES
(1, 'Baccalauréat', 2000.00, 'Privee', 'Français, Anglais', TRUE, FALSE, 90.0),
(2, 'Licence', 5000.00, 'Publique', 'Français', FALSE, TRUE, 80.0);

-- Insertion de données dans la table Correspondance
INSERT INTO `Correspondance` (`idFormation`, `idCritere`) VALUES
(1, 1),
(2, 2),
(3, 2);
