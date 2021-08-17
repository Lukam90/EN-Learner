## S3 - Les utilisateurs

### L'inscription d'un nouvel utilisateur

|||
|-|-|
|Route **/users/register** (invité)|B|
|Formulaire d'inscription|X|
|(+) Fenêtre modale d'inscription|TD|
|Validation simple|X|
|(+) Validation en temps réel|TD|
|Enregistrement d'un utilisateur|TD|
|Redirection vers la page de connexion|TD|

### La connexion d'un utilisateur

|||
|-|-|
|Route **/users/login** (invité)|X|
|Lien "Connexion" (invité)|X|
|Affichage simple du formulaire de connexion|X|
|Affichage du formulaire pour un invité (non connecté)|X|
|Erreur si mauvais e-mail ou mot de passe|TD|
|Erreur si utilisateur banni|TD|
|Redirection vers la page d'accueil|TD|

### L'oubli de mot de passe|améliorations

|||
|-|-|
|La route /users/reset fonctionne|amélioration|
|Le lien "Mot de passe oublié" fonctionne|X|
|Page de demande de mot de passe oublié|bases|
|Fenêtre modale de demande de mot de passe oublié|amélioration|
|Envoi d'un e-mail avec nouveau mot de passe|amélioration|
|Confirmation de l'e-mail avec le nouveau mot de passe|amélioration|

### La déconnexion d'un utilisateur

|||
|-|-|
|La route /users/logout fonctionne|
|Le lien "Déconnexion" fonctionne|
|Redirection vers la page d'accueil|
|Message de succès de déconnexion|

### La page profil d'un utilisateur

|||
|-|-|
|La route /users/profile/{id} fonctionne|
|Le lien "e-mail" fonctionne|
|L'accès fonctionne pour un utilisateur précis et autorisé|
|Le formulaire de changement de pseudo et d'e-mail fonctionne|
|(+) Le formulaire de changement d'e-mail fonctionne en temps réel|
|Le formulaire de changement de mot de passe fonctionne|
|(+) Le formulaire de changement de mot de passe fonctionne en temps réel|

### La liste des utilisateurs

|||
|-|-|
|Route **/users**|X|
|Lien "Communauté"|X|
|Liste des utilisateurs|B|
|Erreur si utilisateur banni|TD|
|Bouton d'ajout (membre)|
|Le bouton "Ajouter" est visible pour un utilisateur connecté et autorisé|
|Message d'absence d'utilisateur|
|Boutons d'édition / suppression visibles par un admin|
|(+) Ordre d'affichage pour chaque colonne|TD|
|(+) Pagination avec 50 résultats par défaut|TD|
|(+) Filtrage des utilisateurs par pseudo|TD|

### L'édition d'un utilisateur

|||
|-|-|
|Route **/users/{id}/update** (admin)|B|
|Bouton d'édition (admin)|B|
|Edition d'un utilisateur (admin)|TD|
|(+) Fenêtre modale d'édition|TD|

### La suppression d'un utilisateur

|||
|-|-|
|Route **/users/{id}/delete** (admin)|TD|
|Bouton de suppression|B|
|Suppression d'un utilisateur|TD|
|(+) Fenêtre modale de suppression|TD|