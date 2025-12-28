# Zoo Virtuel "ASSAD" – Projet Coupe d’Afrique des Nations 2025

## Contexte du projet
À l’occasion de la Coupe d’Afrique des Nations 2025 organisée au Maroc, le Zoo virtuel **"ASSAD"** souhaite promouvoir les lions de l’Atlas et les animaux auprès des supporters et visiteurs du continent.

Ce projet est une refonte complète d’une version précédente réalisée en PHP procédural. Il est développé en **PHP orienté objet (POO)** avec le connecteur **PDO** pour la base de données.

---

## Fonctionnalités – User Stories

### Utilisateurs
- Inscription et connexion sécurisées avec rôle (Visiteur, Guide)
- Gestion des comptes par l’administrateur (activation, désactivation, approbation des guides)

### Guides
- Création, modification et annulation de visites guidées
- Gestion des étapes de chaque visite
- Consultation des réservations pour leurs visites

### Visiteurs
- Consultation de la fiche spéciale “Asaad – Lion des Atlas”
- Liste et filtre des animaux par habitat ou pays
- Consultation des visites guidées disponibles et réservation
- Possibilité de laisser un commentaire et une note après la visite
- Recherche de visites guidées

### Administrateurs
- Gestion CRUD des animaux et habitats
- Visualisation des statistiques :
  - Nombre total de visiteurs inscrits (et par pays)
  - Nombre total d’animaux
  - Animaux les plus consultés
  - Visites guidées les plus réservées

---

## Architecture et Conception

### Diagrammes UML
- Diagramme de cas d’utilisation (Use Case)
- Diagramme de classes UML
  - Classes principales :
    - `Animal` : id, nom, espèce, alimentation, image, paysOrigine, descriptionCourte, id_habitat
    - `Habitat` : id, nom, typeClimat, description, zoneZoo
    - `Utilisateur` : id, nom, email, rôle, motPasseHash
    - `VisiteGuidee` : id, titre, dateHeure, langue, capaciteMax, statut, duree, prix
    - `EtapeVisite` : id, titreEtape, descriptionEtape, ordreEtape, id_visite
    - `Reservation` : id, idVisite, idUtilisateur, nbPersonnes, dateReservation
    - `Commentaire` : id, idVisiteGuidee, idUtilisateur, note, texte, date_commentaire

---

## Technologies utilisées
- **PHP 8+** avec POO
- **PDO** pour la connexion et requêtes SQL sécurisées
- **HTML5 / CSS3 / JavaScript** pour le frontend
- **Git** pour le contrôle de version
- **MySQL** ou **MariaDB** pour la base de données

---

## Abada Aziz – Étudiant Développeur Web Full Stack chez YouCode

