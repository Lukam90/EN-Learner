# English Learner - Structure

## 1) La base

**Vue** : layouts/app.blade.php

Un menu de navigation du site est visible tout en haut de chaque page et contient :
\- le titre English Learner tout à gauche, avec un lien vers la page d'accueil
\- les liens des différentes pages à droite dans cet ordre :
    \- l'adresse e-mail d'un utilisateur connecté, avec un lien vers sa page de profil
    \- Inscription (si non connecté)
    \- Connexion (ou Déconnexion si connecté)
    \- Communauté (liste des utilisateurs)
    \- Listes (liste des thèmes)

Un pied de page est visible tout en bas de chaque page avec la mention English Learner &copy; 2021.

## 2) La page d'accueil

**Route** : / (**home**)

**Vue** : home.blade.php

**Contrôleur** : HomeController (index)

Il s'agit de la page principale, qui sert aussi de page d'affichage de statistiques avec :
\- le nombre d'utilisateurs
\- le nombre de thèmes
\- le nombre d'expressions

Les statistiques sont affichées en blocs sur une même ligne.

Chaque bloc contient un lien vers :
\- la liste des utilisateurs
\- la liste des thèmes
\- la liste des expressions

## 3) La gestion des utilisateurs

### 3.1) L'inscription d'un nouvel utilisateur

**Route** : /register (**auth.register**)

**Vue** : auth/register.blade.php

**Contrôleur** : Auth/RegisterController (create)

**Rôle** : guest

Un utilisateur doit s'inscrire s'il souhaite contribuer à la base de vocabulaire.

Il devra indiquer :
\- son pseudo (requis, unique, alphanumérique, espaces inclus, sans accents, de 2 à 50 caractères)
\- son adresse e-mail (requis, unique, e-mail valide, 180 caractères max)
\- son mot de passe (requis, 8 à 32 caractères avec minuscules, majuscules et chiffres)
\- sa confirmation du mot de passe

Des messages d'erreur s'afficheront en-dessous de chaque champ mal renseigné.

Des messages d'informations indiqueront les règles de validation de chaque champ.

Dans l'idéal, un mot de passe pourra comporter des caractères spéciaux ($, @, !, ?).

Seul un invité (utilisateur non connecté) a accès à cette page.

### 3.2) La connexion d'un utilisateur

**Route** : /login (**auth.login**)

**Vue** : auth/login.blade.php

**Contrôleur** : Auth/LoginController (redirectTo)

**Rôle** : guest

Un utilisateur a le droit de se connecter suivant ces conditions :
\- il n'a pas été banni par un administrateur
\- il n'a pas supprimé son compte
\- son compte n'a pas été supprimé par un administrateur

Un utilisateur est invité à se connecter avec son e-mail et son mot de passe.

Un utilisateur peut demander un nouveau mot de passe si nécessaire en cliquant sur un lien **Mot de passe oublié**.

Un message d'information s'affiche pour confirmer une connexion réussie.

Le cas échéant, un message d'erreur s'affiche.

Dans l'idéal, la connexion sera possible avec une fenêtre modale.

### 3.3) La déconnexion d'un utilisateur

**Route** : /logout

**Redirection** : / (**home**)

**Contrôleur** : Auth/LoginController (?)

**Rôle** : user

Un utilisateur peut se déconnecter en cliquant sur le lien **Déconnexion** du menu de navigation.

Il est ensuite redirigé vers la page d'accueil avec un message de confirmation.

### 3.4) La récupération d'un mot de passe

#### 3.4.1) L'e-mail de réinitialisation

**Route** : /reset (**auth.passwords.email**)

**Vue** : auth/passwords/email.blade.php

**Contrôleur** : ConfirmPasswordController

Sur la première page, un utilisateur est invité à rentrer son adresse e-mail.

Si l'adresse e-mail existe, l'utilisera recevra un e-mail qui le redirigera vers la page de réinitialisation du mot de passe.

Le cas échéant, un message d'erreur indiquera l'inexistence de l'adresse e-mail.

#### 3.4.2) La réinitialisation du mot de passe

**Route** : /new_password (**auth.passwords.reset**)

**Vue** : auth/passwords/reset.blade.php

**Contrôleur** : Auth/ResetPasswordController

L'utilisateur est invité à entrer son nouveau mot de passe et à le confirmer.

Le mot de passe doit respecter les règles de validation définies.

Une fois le nouveau mot de passe défini, l'utilisateur est redirigé vers la page d'accueil avec un message de confirmation l'invitant à se connecter.

#### 3.4.3) La confirmation du nouveau mot de passe

**Route** : /confirm (**auth.passwords.confirm**)

**Vue** : auth/passwords/reset.blade.php

**Contrôleur** : Auth/ResetPasswordController

L'utilisateur arrive sur une page de confirmation de son nouveau mot de passe.

Il est ensuite invité à se rediriger vers la page d'accueil.

### 3.5) La page profil d'un utilisateur

**Route** : users/{id}/profile (**users.profile**)

**Vue** : users/profile.blade.php

**Contrôleur** : UsersController (profile)

**Rôle** : user

Un utilisateur a accès à sa page de profil en cliquant sur son adresse e-mail dans la barre de navigation principale.

Il y retrouve un premier formulaire lui permettant de changer son e-mail et son pseudo.

Dans un second formulaire, il peut changer son mot de passe en indiquant :
\- son ancien mot de passe
\- son nouveau mot de passe
\- la confirmation de son nouveau mot de passe

Un message flash en vert confirme une modification réussie.

### 3.6) La liste des utilisateurs

**Route** : /users (**users.us_index**)

**Vue** : users/us_index.blade.php

**Contrôleur** : UsersController (index)

Cette page liste l'ensemble des utilisateurs sous forme de tableau avec :
\- le pseudo de l'utilisateur
\- le rôle de l'utilisateur (Membre, Modérateur, Administrateur)
\- la date d'inscription, au format JJ/MM/AAAA (ex : 21/06/2021)
\- le nombre de thèmes et d'expressions
\- les boutons d'édition, de suppression et de bannissement (visibles par un administrateur)

Le pseudo de l'utilisateur sera colorié :
\- en vert si c'est un modérateur
\- en rouge si c'est un administrateur

On peut choisir l'ordre d'affichage pour chaque colonne.

Les utilisateurs sont affichés par pages avec un nombre de 50 par défaut.

On peut choisir d'afficher 10, 20, 50, 100 ou 200 utilisateurs par page.

On peut aussi filtrer l'ensemble des utilisateurs avec une barre de recherche.

Un message s'affiche en cas d'absence d'utilisateur inscrit.

### 3.7) L'édition d'un utilisateur

**Route** : /users/{id}/edit (**users.us_edit**)

**Vue** : users/us_edit.blade.php

**Redirection** : /users (**users.us_index**)

**Contrôleur** : UsersController (edit, update)

Un administrateur est redirigé vers un formulaire d'édition d'un utilisateur avec :
\- le rôle de l'utilisateur (membre, modérateur, administrateur)
\- le pseudo de l'utilisateur (en cas d'éventuelle demande)

Dans l'idéal, le formulaire d'édition est intégré dans une fenêtre modale sur la même page.

Un message flash en vert confirme l'édition d'un utilisateur.

### 3.8) La suppression d'un utilisateur

**Route** : /users/{id}/delete (**users.us_delete**)

**Vue** : users/us_delete.blade.php (*)

**Redirection** : /users (**users.us_index**)

**Contrôleur** : UsersController (destroy)

**Rôle** : admin

Un administrateur déclenche une fenêtre modale (*) de confirmation de suppression de l'utilisateur concerné.

Un message flash en vert confirme la suppression d'un utilisateur.

## 4) La gestion des thèmes

### 4.1) La liste des thèmes

**Route** : /themes (**themes.t_index**)

**Vue** : themes/t_index.blade.php

**Contrôleur** : ThemesController (index)

Cette page liste l'ensemble des thèmes sous forme de tableau avec :
\- le titre d'un thème, avec son lien
\- l'auteur du thème
\- le nombre d'expressions
\- les boutons d'édition et de suppression (visibles par un administrateur et un modérateur)

On peut choisir l'ordre d'affichage pour chaque colonne.

Les thèmes sont affichés par pages avec un nombre de 50 par défaut.

On peut choisir d'afficher 10, 20, 50, 100 ou 200 thèmes par page.

On peut aussi filtrer l'ensemble des thèmes avec une barre de recherche.

Un message s'affiche en cas d'absence de thème.

Un utilisateur connecté voit un bouton d'ajout au-dessus de la liste.

### 4.2) L'ajout d'un thème

**Route** : /themes/new (**themes.t_new**)

**Vue** : themes/t_new.blade.php

**Redirection** : /themes (**themes.t_index**)

**Contrôleur** : ThemesController (store)

**Rôle** : user

L'utilisateur est redirigé vers une page avec un formulaire incluant un champ pour le titre du nouveau thème.

Dans l'idéal, le formulaire d'ajout se trouve dans une fenêtre modale sur la même page.

Un message flash en vert confirme l'ajout d'un thème.

### 4.3) L'édition d'un thème

**Route** : /themes/{id}/edit (**themes.t_edit**)

**Vue** : themes/t_edit.blade.php

**Redirection** : /themes (**themes.t_index**)

**Contrôleur** : ThemesController (edit, update)

**Rôle** : user

Un modérateur, un administrateur ou un utilisateur concerné peut modifier un thème.

L'utilisateur est redirigé vers une page avec un formulaire incluant un champ pré-rempli avec l'ancien titre.

Dans l'idéal, le formulaire d'édition se trouve dans une fenêtre modale sur la même page.

Un message flash en vert confirme l'édition d'un thème.

### 4.4) La suppression d'un thème

**Route** : /themes/{id}/delete (**themes.t_delete**)

**Vue** : themes/t_delete.blade.php (*)

**Redirection** : /themes (**themes.t_index**)

**Contrôleur** : ThemesController (destroy)

**Rôle** : moderator

Un modérateur, un administrateur ou un utilisateur concerné peut supprimer un thème.

Une fenêtre modale (*) s'affiche pour confirmer la suppression d'un thème.

Un message flash en vert confirme la suppression d'un thème.

## 5) La gestion des expressions

### 5.1) La liste des expressions d'un thème

**Route** : /themes/{id}/show (**themes.t_show**)

**Vue** : themes/t_show.blade.php

**Contrôleur** : ThemesController (show)

Cette page liste l'ensemble des expressions d'un thème sous forme de tableau avec :
\- l'expression en français
\- la traduction en anglais
\- la transcription phonétique
\- l'auteur de l'expression
\- les boutons d'édition et de suppression (visibles par un administrateur, un modérateur ou un utilisateur concerné)

On peut choisir l'ordre d'affichage pour chaque colonne.

On peut choisir d'afficher 10, 20, 50, 100 ou 200 expressions par page.

On peut aussi filtrer l'ensemble des thèmes avec une barre de recherche.

Un message s'affiche en cas d'absence de thème.

Un utilisateur connecté voit un bouton d'ajout au-dessus de la liste.

### 5.2) La génération de flashcards d'un thème

**Route** : /themes/{id}/game (**themes.game**)

**Vue** : themes/game.blade.php

**Redirection** : /theme/{id} (**themes.show**)

**Contrôleur** : ThemesController (start)

Un utilisateur peut lancer une partie de flashcards sur la page d'un même thème, à partir de 10 expressions.

Il déclenche une fenêtre modale qui l'invite à choisir un niveau de difficulté qui déterminera le nombre d'expressions : facile (10), moyen (15) et difficile (20).

Il est ensuite invité à se remémorer la traduction anglaise de chaque expression affichée avant d'obtenir la réponse en un clic et de passer à la question suivante.

Les questions sont générées de manière aléatoire selon le nombre disponible et le niveau de difficulté.

La réponse est affichée avec un retournement horizontal.

Une fois le jeu terminé, l'utilisateur est invité à rejouer s'il le souhaite.

### 5.3) L'ajout d'une expression

**Route** : /expressions/new (**expressions.ex_new**)

**Vue** : expressions/ex_new.blade.php

**Redirection** : /expressions (**expressions.ex_index**)

**Contrôleur** : ExpressionsController (store)

**Rôle** : user

L'utilisateur est redirigé vers une page avec un formulaire incluant :
\- un champ texte pour l'expression en français
\- un champ texte pour la traduction en anglais
\- un champ texte pour la transcription phonétique

Dans l'idéal, le formulaire d'ajout se trouve dans une fenêtre modale sur la même page.

Un message flash en vert confirme l'ajout d'une expression.

### 5.4) L'édition d'une expression

**Route** : /expressions/{id}/edit (**expressions.ex_edit**)

**Vue** : expressions/ex_edit.blade.php

**Redirection** : /expressions (**expressions.ex_index**)

**Contrôleur** : ExpressionsController (edit, update)

**Rôle** : user

Un modérateur, un administrateur ou un utilisateur concerné peut modifier une expression.

L'utilisateur est redirigé vers une page avec un formulaire incluant :
\- un champ texte pré-rempli avec l'expression en français
\- un champ texte pré-rempli avec la traduction en anglais
\- un champ texte pré-rempli avec la transcription phonétique

Dans l'idéal, le formulaire d'édition se trouve dans une fenêtre modale sur la même page.

Un message flash en vert confirme l'édition d'une expression.

### 5.4) La suppression d'une expression

**Route** : /expressions/{id}/delete (**expressions.ex_delete**)

**Vue** : expressions/ex_delete.blade.php

**Redirection** : /expressions (**expressions.ex_index**)

**Contrôleur** : ExpressionsController (destroy)

**Rôle** : user

Un modérateur, un administrateur ou un utilisateur concerné peut supprimer une expression.

Une fenêtre modale s'affiche pour confirmer la suppression d'une expression.

Un message flash en vert confirme la suppression d'une expression.

