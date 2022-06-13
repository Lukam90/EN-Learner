## Ex 9

Afficher l'historique des notes de l'élève numéro 5 triées de la récente à la plus ancienne (avec la matière associée)

```sql
SELECT CONCAT(e.prenom, ' ', e.nom), n.score, m.libelle
FROM eleve e, note n, matiere m
WHERE e.note_id = n.id
AND n.matiere_id = m.id
AND e.id = 5
ORDER BY n.date DESC
```