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