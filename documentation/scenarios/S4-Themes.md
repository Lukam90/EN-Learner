## S4 - La gestion des thèmes

### La liste des thèmes

|||
|-|-|
|Route **/themes**|B|
|Erreur si non autorisé|TD|
|Liste des thèmes|B|
|Absence de thème|B|
|Bouton d'ajout (membre)|B|
|Bouton d'édition (même membre, modérateur, admin)|B|
|Bouton de suppression (même membre, modérateur, admin)|B|
|(+) Ordre d'affichage des colonnes|TD|
|(+) Pagination avec 50 résultats par défaut|TD|
|(+) Filtre par titre|TD|

### L'ajout d'un thème

|||
|-|-|
|Route **/themes/new** (même membre, modérateur, admin)|TD|
|Erreur si non autorisé|TD|
|Formulaire d'ajout d'un thème|B|
|(+) Fenêtre modale d'ajout d'un thème|TD|
|Validation simple|TD|
|(+) Validation en temps réel|TD|
|Ajout d'un thème|TD|
|Redirection vers la liste des thèmes|TD|
|Message d'ajout d'un thème|TD|

### L'édition d'un thème

|||
|-|-|
|Route **/themes/edit/{id}** (même membre, modérateur, admin)|B|
|Erreur si non autorisé|TD|
|Formulaire d'édition d'un thème|B|
|(+) Fenêtre modale d'édition d'un thème|TD|
|Validation simple d'un thème|TD|
|(+) Validation en temps réel d'un thème|TD|
|Edition d'un thème|TD|
|Redirection vers la liste des thèmes|TD|
|Message d'édition d'un thème|TD|

### La suppression d'un thème

|||
|-|-|
|Route **/themes/delete/{id}** (même membre, modérateur, admin)|B|
|Erreur si non autorisé|TD|
|Suppression d'un thème|TD|
|(+) Fenêtre modale de suppression d'un thème|TD|
|Redirection vers la liste des thèmes|TD|
|Message de suppression d'un thème|TD|