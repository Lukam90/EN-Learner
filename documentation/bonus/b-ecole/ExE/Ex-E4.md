## Ex 4

Afficher la liste des élèves de la classe '5eme B'

```sql
SELECT e.*
FROM eleve e, classe c
WHERE e.classe_id = c.id
AND c.libelle = '5eme B'
```