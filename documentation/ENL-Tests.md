# Scénarios de test

# T1 - Les éléments de base

Mise en place du layout de base [x]

Affichage basique de la barre de navigation [!] : W3 CSS

English Learner > Inscription - Connexion - Communauté - Listes

Affichage / statut de connexion de la barre de navigation []

English Learner > Bienvenue, X - Déconnexion - Communauté - Listes

Affichage du pied de page [!] : W3 CSS, inclusion du lien "Mentions Légales"

Page de "Mentions Légales" [!] : finalisation

Affichage d'un message flash de succès [!] : W3 CSS

Affichage d'un message flash d'erreur [!] : W3 CSS

# T2 - La page d'accueil

La route **home** (/) fonctionne [x] : PHPUnit

Affichage de 3 blocs (nb utilisateurs / thèmes / expressions) [x] : W3CSS

Lien vers la liste des utilisateurs (bloc 1) [x]

Lien vers la liste des thèmes (blocs 2 et 3) [x]

# T - La gestion des utilisateurs

## T - L'inscription d'un nouvel utilisateur

La route **/register** fonctionne []

Affichage du formulaire d'inscription []

Pseudo - Email - Mot de passe + Confirmation - Bouton "S'inscrire" (Vertical)

Affichage du formulaire d'inscription / invité seulement []

Validation simple du formulaire d'inscription []

pseudo (2 à 50) - email (180 max), mot de passe (8 à 32, alphanum), confirmation

L'unicité du pseudo et de l'e-mail est prise en compte []

(+) Validation temps réel du formulaire d'inscription []

(+) Fenêtre modale d'inscription []

## T - La connexion d'un utilisateur

La route **/login** fonctionne []

Le lien "Connexion" fonctionne []

Affichage simple du formulaire de connexion []

Le formulaire de connexion est inaccessible à un utilisateur connecté []

Le formulaire de connexion est inaccessible à un utilisateur banni []

Connexion validée []

Erreur si mauvais e-mail ou mot de passe []

Redirection vers la page d'accueil [] : dossier

## T - (+) L'oubli de mot de passe

La route **/reset** fonctionne []

Le lien "Mot de passe oublié" fonctionne []

Page de demande de mot de passe oublié [] : précisions dossier

Fenêtre modale de demande de mot de passe oublié [] : précisions dossier

Envoi d'un e-mail avec nouveau mot de passe []

Confirmation de l'e-mail avec le nouveau mot de passe []

## T - La déconnexion d'un utilisateur

La route **/logout** fonctionne []

Le lien "Déconnexion" fonctionne []

Redirection vers la page d'accueil []

Message de succès de déconnexion []

## T - La page profil d'un utilisateur

La route **/profile** fonctionne []

Le lien "e-mail" fonctionne []

L'accès fonctionne pour un utilisateur précis et autorisé []

Le formulaire de changement de pseudo et d'e-mail fonctionne []

Unicité du pseudo et de l'e-mail

(+) Le formulaire de changement d'e-mail fonctionne en temps réel []

Le formulaire de changement de mot de passe fonctionne []

(+) Le formulaire de changement de mot de passe fonctionne en temps réel []

## T - La liste des utilisateurs

La route **/users** fonctionne []

Le lien "Communauté" fonctionne []

La liste des utilisateurs s'affiche correctement []

Le bouton "Ajouter" est visible pour un utilisateur connecté et autorisé []

Les rôles sont coloriés []

Modérateur = vert, Admin = Rouge

Message d'absence d'utilisateur []

Boutons d'édition / suppression visibles par un admin []

(+) Ordre d'affichage pour chaque colonne []

(+) Pagination avec 50 par défaut []

(+) Filtrage des utilisateurs par pseudo []

## T - L'édition d'un utilisateur

La route **/users/{id}/update** fonctionne []

Le bouton d'édition fonctionne []

L'édition d'un utilisateur fonctionne []

(+) L'édition d'un utilisateur fonctionne en modal []

## T - La suppression d'un utilisateur

La route **/users/{id}/delete** fonctionne pour un admin seul []

Le bouton de suppression fonctionne []

La suppression d'un utilisateur fonctionne []

Cascade > Suppression des expressions, suivi des thèmes associés

# T - La gestion des thèmes

## T - La liste des thèmes

La route **/register** fonctionne []

Affichage de la liste des thèmes []

Absence de thème []

Bouton d'ajout / utilisateur connecté []

Bouton d'édition / suppression pour un même utilisateur, un modo et un admin []

Ordre d'affichage des colonnes []

Pagination avec 50 par défaut []

Filtre par titre []

## T - L'ajout d'un thème

La route **/themes/new** fonctionne []

\- user autorisé, modo, admin

Titre obligatoire []

Redirection vers la liste []

(+) Titre obligatoire en temps réel []

(+) Ajout en modal

## T - L'édition d'un thème

Route **/themes/:id/edit** []

\- user = autorisé, modo, admin

Formulaire d'édition + validation []

(+) Validation en réel

Redirection vers la liste []

(+) Edition en modal

## T - La suppression d'un thème

Route **/themes/:id/delete** []

\- user = autorisé, modo, admin

Redirection vers la liste []

Suppression en modal []

\- Cascade avec suppression des expressions liées au thème

# T - La gestion des expressions

## T - La liste des expressions d'un thème

Route **/themes/{id}/show** valide []

Affichage de la liste []

Bouton d'ajout / user autorisé []

Absence d'expression []

Ordre d'affichage / colonne []

Pagination avec n = 50 []

Filtre par expression (FR) []

## T - (+) La génération de flashcards d'un thème

Route **/themes/{id}/start** valide [] : invité ?

Bouton de jeu si N > 10 []

Niveau de difficulté dès 15 (facile - moyen) []

Niveau difficile dès N >= 20 []

Génération de N flashcards aléatoires []

Revanche []

## T - L'ajout d'une expression

Route **/expressions/new** valide []

Formulaire d'ajout + validation []

(+) Validation en temps réel []

(+) Ajout en modal []

## T - L'édition d'une expression

Route **/expressions/:id/edit** valide []

\- user autorisé =, modo, admin

Formulaire d'édition + validation []

(+) Validation en temps réel []

(+) Edition en modal []

## T - La suppression d'une expression

Route **/expressions/:id/delete** valide []

\- user autorisé =, modo, admin

Suppression en modal []

