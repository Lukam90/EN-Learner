## Ex 6

Afficher le nombre d'heures totales dispensées par tous les professeurs toute classe confondue

```sql
SELECT p.*, SUM(p.nb_heures)
FROM professeur p, classe c, enseigne e
WHERE p.id = e.professeur_id
AND e.classe_id = c.id
GROUP BY p.id
```