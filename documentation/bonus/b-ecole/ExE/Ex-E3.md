## Ex 3

Afficher la liste des professeurs qui enseignent les maths

```sql
SELECT p.*
FROM professeur p, matiere m
WHERE p.matiere_id = m.id
AND m.libelle = 'maths'
```