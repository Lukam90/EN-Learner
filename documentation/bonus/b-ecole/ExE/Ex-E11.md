## Ex 11

Afficher les 3 meilleurs élèves de la classe "3eme C" (avec leur moyenne respective)

```sql
SELECT CONCAT(e.prenom, ' ', e.nom), AVG(SUM(n.score))
FROM eleve e, note n, classe c
WHERE e.classe_id = c.id
AND n.eleve_id = n.id
AND c.libelle = '3eme C'
GROUP BY AVG(SUM(n.score))
ORDER BY AVG(SUM(n.score)) DESC
LIMIT 3
```