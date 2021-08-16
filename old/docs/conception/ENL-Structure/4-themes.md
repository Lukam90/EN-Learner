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