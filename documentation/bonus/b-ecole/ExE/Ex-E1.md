## Ex 1

Afficher toutes les classes + professeur principal

```sql
SELECT c.*, pr.*
FROM classe c, professeur pr, principal pa
WHERE pr.id = pa.professeur_id
AND pa.classe_id = c.id
```