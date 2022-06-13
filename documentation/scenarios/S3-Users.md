## S3 - Les utilisateurs

### L'inscription d'un nouvel utilisateur

|||
|-|-|
|Route **/users/register** (invité)|B|
|Erreur si utilisateur connecté|TD|
|Formulaire d'inscription|X|
|(+) Fenêtre modale d'inscription|TD|
|Validation simple|X|
|(+) Validation en temps réel|TD|
|Enregistrement d'un utilisateur|TD|
|Redirection vers la page de connexion|TD|
|Message d'inscription|TD|

### La connexion d'un utilisateur

|||
|-|-|
|Route **/users/login** (invité)|X|
|Lien "Connexion" (invité)|X|
|Erreur si utilisateur non autorisé|TD|
|Affichage simple du formulaire de connexion|X|
|Affichage du formulaire pour un invité (non connecté)|X|
|Erreur si mauvais e-mail ou mot de passe|TD|
|Redirection vers la page d'accueil|TD|
|Message de connexion|TD|

### (+) L'oubli de mot de passe

|||
|-|-|
|(+) Route **/users/reset** (invité)|TD|
|(+) Erreur si connecté|TD|
|(+) Lien "Mot de passe oublié"|B|
|(+) Page de demande de mot de passe oublié|B|
|(+) Fenêtre modale de demande de mot de passe oublié|TD|
|(+) Envoi d'un e-mail avec nouveau mot de passe|TD|
|(+) Confirmation de l'e-mail avec le nouveau mot de passe|TD|
|(+) Message de confirmation de nouveau mot de passe|TD|

### La déconnexion d'un utilisateur

|||
|-|-|
|Route **/users/logout** (membre)|TD|
|Lien "Déconnexion" (membre)|B|
|Redirection vers la page d'accueil|TD|
|Message de déconnexion|TD|
|Message d'erreur si déjà déconnecté|TD|

### La page profil d'un utilisateur

|||
|-|-|
|Route **/users/profile/{id}** (même membre)|TD|
|Lien de profil avec nom d'utilisateur|B|
|Erreur si non autorisé|TD|
|Formulaire de changement de pseudo et d'e-mail|B|
|Validation simple pseudo - e-mail|TD|
|(+) Validation en temps réel pseudo - e-mail|TD|
|Message de confirmation de nouveaux identifiants|TD|
|Formulaire de changement de mot de passe|B|
|Validation du nouveau mot de passe|B|
|(+) Validation en temps réel du nouveau mot de passe|TD|
|Message de confirmation de nouveau mot de passe|TD|

### La liste des utilisateurs

|||
|-|-|
|Route **/users**|X|
|Lien "Communauté"|X|
|Erreur si non autorisé|TD|
|Liste des utilisateurs|B|
|Absence d'utilisateur|B|
|Bouton d'édition d'un utilisateur (admin)|TD|
|Bouton de suppression d'un utilisateur (admin)|TD|
|(+) Ordre d'affichage pour chaque colonne|TD|
|(+) Pagination avec 50 résultats par défaut|TD|
|(+) Filtrage des utilisateurs par pseudo|TD|

### L'édition d'un utilisateur

|||
|-|-|
|Route **/users/update/{id}** (admin)|B|
|Bouton d'édition d'un utilisateur (admin)|B|
|Edition d'un utilisateur (admin)|TD|
|(+) Fenêtre modale d'édition d'un utilisateur|TD|
|Message d'édition d'un utilisateur|TD|

### La suppression d'un utilisateur

|||
|-|-|
|Route **/users/delete/{id}** (admin)|TD|
|Bouton de suppression d'un utilisateur|B|
|Suppression d'un utilisateur|TD|
|(+) Fenêtre modale de suppression|TD|
|Message de suppression d'un utilisateur|TD|