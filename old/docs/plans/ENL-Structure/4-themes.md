## La gestion des thèmes

### La liste des thèmes

**Route** : /themes

**Vue** : themes.twig

**Contrôleur** : ThemeController (index)

Cette page liste l'ensemble des thèmes sous forme de tableau avec :
- le titre d'un thème, suivi de son lien
- l'auteur du thème
- le nombre d'expressions
- les boutons d'édition et de suppression (même utilisateur, modérateur et administrateur)

Un message s'affiche en cas d'absence de thème.

Un utilisateur connecté voit un bouton d'ajout au-dessus de la liste.

Un même utilisateur peut modifier et supprimer ses thèmes.

**Améliorations**

On peut choisir l'ordre d'affichage pour chaque colonne.

Les thèmes sont affichés par pages avec un nombre de 50 par défaut.

On peut choisir d'afficher 10, 20, 50, 100 ou 200 thèmes par page.

On peut filtrer l'ensemble des thèmes avec une barre de recherche.

### L'ajout d'un thème

**Route** : /themes/new

**Vue** : themes/new_theme.twig

**Redirection** : /themes

**Contrôleur** : ThemeController (create)

**Rôle** : (même) utilisateur

L'utilisateur est redirigé vers une page avec un formulaire incluant un champ pour le titre du nouveau thème.

**Améliorations**

Le formulaire d'ajout se trouve dans une fenêtre modale.

La validation du formulaire (titre obligatoire) se fait en temps réel.

### L'édition d'un thème

**Route** : /themes/{id}/edit

**Vue** : themes/edit_theme.twig

**Redirection** : /themes

**Contrôleur** : ThemeController (update)

**Rôle** : (même) utilisateur

Un modérateur, un administrateur ou un même utilisateur peut modifier un thème.

L'utilisateur est redirigé vers un formulaire avec un champ pré-rempli par l'ancien titre.

**Améliorations**

Le formulaire d'ajout se trouve dans une fenêtre modale.

La validation du formulaire (titre obligatoire) se fait en temps réel.

### La suppression d'un thème

**Route** : /themes/{id}/delete

**Vue** : themes/delete_theme.twig (*)

**Redirection** : /themes

**Contrôleur** : ThemeController (delete)

**Rôle** : (même) utilisateur

Un modérateur, un administrateur ou un même utilisateur peut supprimer un thème.

Une fenêtre modale (*) s'affiche pour confirmer la suppression du thème.

La suppression d'un thème entraîne également la suppression de l'ensemble de ses expressions.