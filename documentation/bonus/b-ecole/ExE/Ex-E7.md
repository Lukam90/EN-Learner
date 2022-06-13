## Ex 7

Afficher la liste des classes totalisant un nombre d'élèves supérieur ou égal à 15

```sql
SELECT c.libelle, SUM(e.id)
FROM classe c, eleve e
WHERE e.classe_id = c.id
GROUP BY c.libelle
HAVING SUM(e.id) >= 15
```