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