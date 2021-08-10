## La gestion des utilisateurs

### L'inscription d'un nouvel utilisateur

**Route** : /register

**Vue** : users/register.twig

**Contrôleur** : UserController (register)

**Rôle** : invité

Un utilisateur doit s'inscrire s'il souhaite contribuer à la base de vocabulaire.

Il devra indiquer :
- son pseudo (requis, unique, alphanumérique, espaces inclus, sans accents, de 2 à 50 caractères)
- son adresse e-mail (requis, unique, e-mail valide, 180 caractères max)
- son mot de passe (requis, 8 à 32 caractères avec minuscules, majuscules et chiffres)
- sa confirmation du mot de passe

Des messages d'erreur s'afficheront en-dessous de chaque champ mal renseigné.

**Améliorations**

La validation du formulaire se fait en temps réel avec des messages indiquant les règles de validation de chaque champ.

Un mot de passe peut comporter des caractères spéciaux ($, @, !, ?).

Le formulaire de connexion s'affiche dans une fenêtre modale.

### La connexion d'un utilisateur

**Route** : /login

**Vue** : users/login.twig

**Contrôleur** : UserController (login)

**Rôle** : invité

Un utilisateur a le droit de se connecter suivant ces conditions :
- il n'a pas été banni par un administrateur
- son compte n'a pas été supprimé

Un utilisateur est invité à se connecter avec son e-mail et son mot de passe.

**Améliorations**

Le formulaire de connexion se trouve dans une fenêtre modale.

Un utilisateur peut demander un nouveau mot de passe si nécessaire en cliquant sur un lien **Mot de passe oublié**.

Il reçoit ensuite un e-mail avec son nouveau mot de passe.

### La déconnexion d'un utilisateur

**Route** : /logout

**Redirection** : / (**home**)

**Contrôleur** : UserController (logout)

**Rôle** : utilisateur

Un utilisateur peut se déconnecter en cliquant sur le lien **Déconnexion** du menu de navigation.

Il est ensuite redirigé vers la page d'accueil avec un message de confirmation.

### La page profil d'un utilisateur

**Route** : /profile/{id}

**Vue** : users/profile.twig

**Contrôleur** : UserController (profile)

**Rôle** : (même) utilisateur

Un utilisateur a accès à sa page de profil en cliquant sur son pseudo dans la barre de navigation principale.

Il y retrouve son nombre de thèmes et d'expressions suggérés.

Il peut aussi modifier ses identifiants.

Un premier formulaire lui permet de changer son e-mail et son pseudo.

L'e-mail et le pseudo doivent rester uniques.

Un second formulaire lui permet de changer son mot de passe en indiquant :
- son ancien mot de passe
- son nouveau mot de passe
- la confirmation de son nouveau mot de passe

**Améliorations**

La validation des formulaires se fait en temps réel.

### La liste des utilisateurs

**Route** : /users

**Vue** : users.twig

**Contrôleur** : UsersController (index)

Cette page liste l'ensemble des utilisateurs sous forme de tableau avec :
- le pseudo de l'utilisateur
- le rôle de l'utilisateur (Membre, Modérateur, Administrateur)
- la date d'inscription, au format JJ/MM/AAAA (ex : 21/06/2021)
- le nombre de thèmes
- le nombre d'expressions
- des boutons d'édition et de suppression (administrateur)
- un bouton de changement de rôle (administrateur)
- un bouton de (dé)bannissement (administrateur)

Le pseudo de l'utilisateur sera colorié :
- en vert, si c'est un modérateur
- en rouge, si c'est un administrateur

Un message s'affiche en cas d'absence d'utilisateur inscrit.

**Améliorations**

On peut choisir l'ordre d'affichage pour chaque colonne.

Les utilisateurs sont affichés par pages avec un nombre de 50 par défaut.

On peut choisir d'afficher 10, 20, 50, 100 ou 200 utilisateurs par page.

On peut filtrer l'ensemble des utilisateurs avec une barre de recherche.

### L'édition d'un utilisateur

**Route** : /users/{id}/update

**Vue** : users/edit_user.twig

**Redirection** : /users

**Contrôleur** : UserController (update)

**Rôle** : administrateur

Un administrateur est redirigé vers un formulaire d'édition d'un utilisateur avec :
- le rôle de l'utilisateur (membre, modérateur, administrateur)
- le statut de bannissement (case à cocher)

**Améliorations**

Le formulaire d'édition est intégré dans une fenêtre modale.

### La suppression d'un utilisateur

**Route** : /users/{id}/delete

**Vue** : users/delete_user.twig (*)

**Redirection** : /users

**Contrôleur** : UserController (delete)

**Rôle** : administrateur

Un administrateur déclenche une fenêtre modale (*) de confirmation de suppression de l'utilisateur concerné.

La suppression d'un utilisateur entraîne également la suppression de l'ensemble de ses thèmes et expressions.