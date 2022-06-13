### 2b)

Liste des séances (créneaux horaires) pour la journée d’aujourd’hui pour un film en particulier

```sql
SELECT se.horaire
FROM seance se, salle sa, film f
WHERE se.salle_id = sa.id
AND f.salle_id = sa.id
AND se.date = DATE(NOW())
AND f.id = 1
```