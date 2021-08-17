## La gestion des expressions

### La liste des expressions d'un thème

**Route** : /themes/show/{id}

**Vue** : themes/show_theme.twig

**Contrôleur** : ThemeController (show)

Cette page liste l'ensemble des expressions d'un thème sous forme de tableau avec :
- l'expression en français
- la traduction en anglais
- la transcription phonétique
- l'auteur de l'expression
- les boutons d'édition et de suppression (modérateur, administrateur ou même utilisateur)

Un utilisateur connecté voit un bouton d'ajout au-dessus de la liste.

Un message s'affiche en cas d'absence d'expression.

**Améliorations**

On peut choisir l'ordre d'affichage pour chaque colonne.

On peut choisir d'afficher 10, 20, 50, 100 ou 200 expressions par page.

On peut aussi filtrer l'ensemble des thèmes avec une barre de recherche.

### La génération de flashcards d'un thème

**Route** : /themes/start/{id}

**Vue** : themes/game.twig

**Redirection** : /themes/show/{id}

**Contrôleur** : ThemeController (start)

**Rôle** : utilisateur

Un utilisateur peut lancer une partie de flashcards recto-verso sur la page d'un même thème, à partir de 10 expressions.

Il déclenche une fenêtre modale qui l'invite à choisir un niveau de difficulté qui déterminera le nombre d'expressions : facile (10), moyen (15) et difficile (20).

Il est ensuite invité à se remémorer la traduction anglaise de chaque expression affichée avant d'obtenir la réponse en un clic et de passer à la question suivante.

Les questions sont générées de manière aléatoire selon le nombre disponible et le niveau de difficulté.

La réponse est affichée avec un effet de retournement horizontal.

Une fois le jeu terminé, l'utilisateur est invité à rejouer s'il le souhaite.

### L'ajout d'une expression

**Route** : /expressions/new

**Vue** : expressions/new_expression.twig

**Redirection** : /expressions

**Contrôleur** : ExpressionController (create)

**Rôle** : utilisateur

L'utilisateur est redirigé vers une page avec un formulaire incluant :
- un champ texte pour l'expression en français
- un champ texte pour la traduction en anglais
- un champ texte pour la transcription phonétique

**Améliorations**

Le formulaire d'ajout se trouve dans une fenêtre modale.

La validation du formulaire se fait en temps réel.

### L'édition d'une expression

**Route** : /expressions/edit/{id}

**Vue** : expressions/edit_expression.twig

**Redirection** : /themes/show/{id}

**Contrôleur** : ExpressionController (update)

**Rôle** : (même) utilisateur

Un modérateur, un administrateur ou un même utilisateur peut modifier une expression.

L'utilisateur est redirigé vers un formulaire incluant :
- un champ texte pré-rempli avec l'expression en français
- un champ texte pré-rempli avec la traduction en anglais
- un champ texte pré-rempli avec la transcription phonétique

**Améliorations**

Le formulaire d'édition se trouve dans une fenêtre modale.

La validation du formulaire (champs obligatoires) se fait en temps réel.

### La suppression d'une expression

**Route** : /expressions/delete/{id}

**Vue** : expressions/delete_expression.twig

**Redirection** : /themes/show/{id}

**Contrôleur** : ExpressionController (delete)

**Rôle** : (même) utilisateur

Un modérateur, un administrateur ou un même utilisateur peut supprimer une expression.

Il est ensuite redirigé vers la page de suppression d'une expression.

**Améliorations**

Une fenêtre modale s'affiche pour confirmer la suppression d'une expression.