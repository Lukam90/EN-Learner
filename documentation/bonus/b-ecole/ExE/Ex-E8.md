## Ex 8

Afficher les professeurs qui ne SONT PAS professeurs principaux

```sql
SELECT pr.*
FROM professeur pr, principal pa
WHERE pr.id = pa.professeur_id
AND pa.classe_id IS NULL
```