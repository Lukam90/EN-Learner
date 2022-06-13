# Jeu d'essai

Un invité doit respecter certaines règles de validation pour s'inscrire en tant que nouveau membre.

|Entrée|Résultat|
|-|-|
|le nom d'utilisateur (ou pseudo)||
|||
|Le pseudo n'est pas renseigné|erreur|
|Le pseudo comporte un caractère non alphanumérique|erreur|
|Le pseudo comporte moins de 2 caractères|erreur|
|Le pseudo comporte entre 2 et 32 caractères|**validé**|
|Le pseudo comporte plus de 32 caractères|erreur|
|||
|l'adresse e-mail||
|||
|L'adresse e-mail n'est pas renseignée|erreur|
|L'adresse e-mail n'a pas un format valide|erreur|
|L'adresse e-mail a un format valide|**validé**|
|L'adresse e-mail comporte plus de 100 caractères|erreur|
|||
|le mot de passe||
|||
|Le mot de passe n'est pas renseigné|erreur|
|Le mot de passe comporte un caractère non alphanumérique|erreur|
|Le mot de passe comporte moins de 8 caractères|erreur|
|Le mot de passe comporte entre 8 et 32 caractères|**validé**|
|Le mot de passe comporte plus de 32 caractères|erreur|
|||
|la confirmation du mot de passe||
|||
|La confirmation est différente du mot de passe renseigné précédemment|erreur|
|La confirmation est égale au mot de passe renseigné précédemment|**validé**|