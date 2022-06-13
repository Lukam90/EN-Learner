## Ex 2

Afficher la liste des classes dont Virgile (id_prof = 33) est le professeur principal

```sql
SELECT c.*
FROM classe c, professeur pr, principal pa
WHERE c.id = pa.classe_id
AND pa.professeur_id = pr.id
AND pr.id = 33
```