## S5 - La gestion des expressions

### La liste des expressions d'un thème

|||
|-|-|
|Route **/themes/{id}/show**|B|
|Erreur si banni|TD|
|Liste des expressions|B|
|Absence d'expression|B|
|Bouton d'ajout (membre)|B|
|(+) Ordre d'affichage / colonne|TD|
|(+) Pagination avec 50 résultats par défaut|TD|
|(+) Filtre par expression (français et anglais)|TD|

### (+) La génération de flashcards d'un thème

|||
|-|-|
|Route **/themes/{id}/start**|TD|
|Erreur si banni|TD|
|Bouton de jeu (N > 10)|TD|
|Niveaux facile - moyen (N >= 15)|TD|
|Niveau difficile (N >= 20)|TD|
|Génération de N flashcards aléatoires|TD|
|Proposition de revanche|TD|

### L'ajout d'une expression

|||
|-|-|
|Route **/expressions/new**|B|
|Erreur si banni|TD|
|Formulaire d'ajout|B|
|(+) Fenêtre modale d'ajout|TD|
|Validation simple|TD|
|(+) Validation en temps réel|TD|
|Ajout de thème|TD|

### L'édition d'une expression

|||
|-|-|
|Route /expressions/edit/{id} (même membre, modérateur, admin)|B|
|Erreur si banni|TD|
|Formulaire d'édition|B|
|(+) Fenêtre modale d'édition|TD|
|Validation simple|TD|
|(+) Validation en temps réel|TD|
|Edition d'une expression|TD|

### La suppression d'une expression

|||
|-|-|
|Route **/expressions/delete/{id}** (même membre, modérateur, admin)|B|
|Erreur si banni|TD|
|Suppression d'un utilisateur|TD|
|(+) Fenêtre modale de suppression|TD|