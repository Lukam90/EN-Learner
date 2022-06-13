## S5 - La gestion des expressions

### La liste des expressions d'un thème

|||
|-|-|
|Route **/themes/show/{id}**|B|
|Erreur si thème inexistant|TD|
|Erreur si non autorisé|TD|
|Liste des expressions|B|
|Absence d'expression|B|
|Bouton d'ajout d'une expression (membre)|B|
|Bouton d'édition d'une expression (même membre, modérateur, admin)|B|
|Bouton de suppression d'une expression (même membre, modérateur, admin)|B|
|(+) Ordre d'affichage par colonne|TD|
|(+) Pagination avec 50 résultats par défaut|TD|
|(+) Filtre par expression (français et anglais)|TD|

### (+) La génération de flashcards d'un thème

|||
|-|-|
|(+) Route **/themes/{id}/start**|TD|
|(+) Erreur si non autorisé|TD|
|(+) Bouton de jeu (N >= 10)|TD|
|(+) Erreur si jeu avec N < 10|TD|
|(+) Niveaux facile - moyen (N >= 15)|TD|
|(+) Niveau difficile (N >= 20)|TD|
|(+) Génération de 10 à N <= 20 flashcards aléatoires|TD|
|(+) Proposition de revanche|TD|

### L'ajout d'une expression

|||
|-|-|
|Route **/expressions/new**|B|
|Erreur si non autorisé|TD|
|Formulaire d'ajout d'une expression|B|
|(+) Fenêtre modale d'ajout d'une expression|TD|
|Validation simple d'une expression|TD|
|(+) Validation en temps réel d'une expression|TD|
|Ajout d'une expression|TD|
|Message d'ajout d'une expression|TD|

### L'édition d'une expression

|||
|-|-|
|Route **/expressions/edit/{id}** (même membre, modérateur, admin)|B|
|Erreur si non autorisé|TD|
|Formulaire d'édition d'une expression|B|
|(+) Fenêtre modale d'édition d'une expression|TD|
|Validation simple d'une expression|TD|
|(+) Validation en temps réel d'une expression|TD|
|Edition d'une expression|TD|
|Message d'édition d'une expression|TD|

### La suppression d'une expression

|||
|-|-|
|Route **/expressions/delete/{id}** (même membre, modérateur, admin)|B|
|Erreur si non autorisé|TD|
|Suppression d'un utilisateur|TD|
|(+) Fenêtre modale de suppression|TD|
|Message de suppression d'une expression|TD|