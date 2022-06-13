# Présentation - Notes

## Bases

### Page de garde

Présentation

Prénom / Nom

Projet

Mise en pratique des compétences dev web front-end et back-end 

### Sommaire

Résumé du sommaire

I – Le cahier des charges
II – Les outils
III – La base de données
IV – L’architecture
V – La sécurité
VI – La stratégie de développement
VII – Les difficultés rencontrées
VIII – La démonstration
IX – Les axes d’amélioration

### Introduction

Intérêt pour les langues > EN

EN = base pour les voyages et les langues, informatique, dev

Intérêt pour le développement web

Débuts avec le  SdZ : HTML, CSS, PHP

Pratique et apprentissage en autodidacte

Formation chez Elan

### Présentation du projet

Base de vocabulaire en anglais, par et pour des francophones

Limite de l'audio VS pratique orale

Différence avec accents

Limite IPA (alphabet phonétique international) : maîtrise, clavier

Communauté et contributions

Nb thèmes / expressions / utilisateurs ~ messages (forum)

Rôles :
\- membres (ajout de thèmes et expressions)
\- modérateurs (édition / suppression de thèmes et expressions)
\- admins (tout, même les utilisateurs)

Révision : Flashcards, inspiré de Anki et Mosalingua

## I – Le cahier des charges

### 1) Les règles de base

Ergonomie :
\- Simple et agréable à utiliser (User eXperience)
\- Expérience de l'utilisateur

Responsive : PC, tablette, téléphone (mobile)

Multi-utilisateurs : app web

Messages flash

Confirmation : connexion, ajout d'un thème
Erreur : accès à une page ou action non autorisée

Réglement Général de Protection des Données :
\- intégrité des données
\- infos pertinentes : pseudo et e-mail
\- e-mails non visibles, liste users

Sécurité > RGPD

### 2) L'accueil

Stats générales > Liens

Thèmes / Expressions > Listes des thèmes
Utilisateurs > Liste des utilisateurs

### 3) Les utilisateurs

Espace membre : (dé)connexion, page de profil

R Liste

Edition (admin) : statut (banni), rôle (membre, modérateur)
Suppression (admin) : tous sauf lui-même

R Contributions

### 4) Les thèmes

R Listes de thèmes (vocabulaire)

Ajout : membre
Edition / Suppression : modérateur

Suppression User > Thèmes (lien)

### 5) Les expressions

R Liste expressions / thème

Ajout : membre
Edition / Suppression : modérateur

Suppression Thèmes > Expressions (lien)
Suppression User > Thèmes > Expressions (lien)

R Flashcards > Démo

## II – Les outils

### 1) La conception

LucidChart : maquettes et schéma BDD (dossier de synthèse)

VS Code : éditeur de textes, vu en formation, stage et général

Github : gestionnaire de versions, base du développeur, répertoire public

LAMP : Linux Apache MySQL PHP, plate-forme de dev web en PHP

phpMyAdmin : outil d'administration de BDD avec MySQL, aussi indépendant de PHP

Composer : gestionnaire de dépendances en PHP (avec Symfony et Laravel)

### 2) Le développement

Partie front-end / navigateur / client / visible

HTML : structure avec balises, murs d'une maison
CSS : design avec feuilles de style, déco d'une maison

SCSS : Syntactically Awesome Style Sheets (Sass)

Préprocesseur, syntaxe, fonctionnalités supplémentaires > limites du CSS

Variables, inclusion de fichiers, mixins (sélecteurs), sélecteurs imbriqués

Design repris de W3.CSS (sur W3Schools), minimaliste mais efficace

JS : intéractions, plomberie / électricité d'une maison

\- fenêtre modale de confirmation
\- icône "burger" d'un menu responsive
\- effacer un message flash
\- outil de révision

Partie back-end

PHP : grand classique, vu en formation

MySQL : SGBD (Système de Gestion de Base de Données), relationnel, avec SQL

Twig :
\- moteur de templates pour les pages (originaire de Symfony)
\- pratique et sécurité

## III – La base de données

### La base de données

Description du schéma de la BDD avec cardinalités

Un utilisateur peut suggérer plusieurs expressions.

Un utilisateur peut suggérer plusieurs thèmes.

Un thème est suggéré par un utilisateur.

Un thème peut classer plusieurs expressions.

Une expression est suggérée par un utilisateur.

Une expression est classée par un thème.

## IV – L'architecture

### Le design pattern MVC

Description MVC (Modèle Vue Contrôleur)

Framework personnel

Router : routeur selon lien du navigateur (/themes)

Redirection : /add (ajout)

ThemesController :

Contrôleur = Partie logique d'un composant (liste, ajout, édition, suppression d'un thème)

Contrôleur des thèmes

index() = liste des thèmes

Appel de la vue themes.twig

Vue = Page visible côté client / navigateur

Appel du modèle Theme

Modèle = Classe liée à une table, intéractions avec la BDD

findAll() = sélection de l'ensemble des thèmes > Vue

### L'architecture

R framework perso

## V – Sécurité

### La sécurité

R Sécurité

mots de passe : hachage, réutilisés sur d'autres sites (Gmail, FB...), méthode BCrypt

XSS : Cross Site Scripting

injection de code JS dans un formulaire

affichage cookies avec mot de passe admin

détournement sur un autre site (bancaire, compte FB)

échappement de caractères HTML > fonction, Twig

CSRF : Cross Site Request Forgery

vol de session avec le navigateur

lien de phishing

connexion avec compte admin

jeton CSRF caché dans les formulaires

expiration = action annulée

Injections SQL :

requête SQL dans le navigateur / un formulaire

récupération de mots de passe / connexion admin

requêtes paramétrées avec PDO (PHP Data Objects)

échappement auto avec Twig

DDoS : deni de service

Présence de captchas VS bots

Validation des données :

pseudo alphanum (+ espaces) avec de 2 à 32 caractères

éviter des caractères spéciaux (faille XSS ou injection SQL)

Rôles :

actions permises pour certains utilisateurs (édition et suppression)

### Sécurité - Exemples

Ex 1 :

Sélection d'un thème par ID

Requête paramétrée, ID = entier

Méthodes définies dans une (super)classe Model

Ex 2

Jeton CSRF caché dans un formulaire avec Twig

## VI – La stratégie de développement

### Pourquoi un framework personnel ?

une grande liberté VS règles d'un framework

une meilleure maîtrise du code VS maîtrise du code d'un framework

mise en pratique de la POO

défi perso : différence (VS Symfony et Laravel), fonctionnement d'un framework MVC

### Données de test (CSV)

Script seeder.php

Création de la table des thèmes (modèle)

Object Faker avec CSV pour les thèmes, nom du fichier, colonnes

Boucle d'insertion des valeurs

~ Fixtures (Symfony, Laravel)

### Les tests unitaires (PHPUnit)

Test unitaire pour la liste des thèmes

findAll() du modèle Theme

Nombre de lignes dans un fichier avec nom de la méthode

Vérifie si liste non vide

Sinon, erreur et arrêt des tests (STOP)

## VII – Les difficultés rencontrées

### Les difficultés rencontrées

Choix technos :
\- PHP (+ Symfony) par défaut VS Laravel
\- Python (Flask, Django)
\- NodeJS (Express)
\- composants (React, Vue)

Architecture :

Inspiration de frameworks existants (Elan, Laravel, exemples YTB ~ Traversy Media)

Organisation du code :

Architecture + Orienté Objet

Intéractions BDD :

Requêtes, appels, fonctionnel

Tests :
\- Script seeder.php avec fichiers CSVs
\- Compréhension et mise en place de PHPUnit

Design :

Reprise des meilleurs éléments de W3.CSS

Réadaptation en CSS avec SCSS, appris sur le tas

## VIII – La démonstration

### La démonstration

**Page d'accueil**

Navigation

Blocs de stats + liens

Responsive + Burger

**1) Inscription d'un utilisateur**

Link

link@test.com

Zelda007

Mario123

**2) Connexion d'un utilisateur**

Page de profil

Liste des thèmes

Consultation du thème "Expressions de base"

Ajout d'un nouveau thème "Les pays"

Création de 3 expressions :

l'Espagne - Spain - spé-ine

l'Angleterre - England - ine-glén-de

l'Italie - Italy - iteu-li

Edition de l'expression du milieu

le Royaume-Uni - the United Kingdom - de you-naï-tide kine-dome

Suppression de la première expression

**3) Connexion d'un administrateur**

lukas@admin.com - Admin007

Liste des thèmes

Consultation du thème "Les animaux"

Edition du thème en "Animaux"

Suppression du thème "Animaux"

Consultation du thème "Les mois" de Mister Bean

Liste des utilisateurs

Voir édition du statut de Mister Bean

Suppression de l'utilisateur Mister Bean

Retour à la liste des thèmes

Thème supprimé = "Les mois"

Expressions supprimées de Mister Bean

**4) Outil de révision**

Déconnexion de l'administrateur

Liste des thèmes

Consultation du thème "Expressions de base"

Lancement de la révision

Choix du niveau "Moyen (15)"

Sélection de flashcards

Relance du jeu

## IX – Les axes d'amélioration

### Axes d’amélioration

JS, Vue et Firebase : éventuelle spécialisation

RGPD : barre de cookies, mentions légales

Pagination / nombre de résultats (ex : 20, 50, 100 thèmes)

Filtres de recherche (thème, expression)

Réinitialisation du mot de passe par e-mail

API audio avec choix d'accents (UK, US)

Niveaux des thèmes (ex : expressions de base, politique)

Section Blog > articles

### Conclusion

Ravi de présenter le projet English Learner

Ravi d'avoir suivi la formation chez Elan

Voie de développeur web

"Je vous remercie encore pour votre attention !"

"Si vous avez des questions, n'hésitez pas !"