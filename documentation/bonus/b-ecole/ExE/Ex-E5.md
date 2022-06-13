## Ex 5

Afficher le nombre d'heures totales dispensées par le professeur Stéphane (id_prof = 12) toute classe confondue (on affichera le nom / prénom du professeur)

```sql
SELECT CONCAT(p.nom, ' ', p.prenom) as prof, SUM(p.nb_heures)
FROM professeur p, classe c, enseigne e
WHERE p.id = e.professeur_id
AND e.classe_id = c.id
AND p.id = 12
GROUP BY prof
```