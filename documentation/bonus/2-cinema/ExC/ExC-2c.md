### 2c)

Liste des films (mêmes champs que la question a) sans les horaires) qui durent plus de 2h

```sql
SELECT f.titre, r.*, f.duree
FROM film f, realisateur r, seance se, salle sa
WHERE se.salle_id = sa.id
AND f.salle_id = sa.id
AND f.realisateur_id = r.id
AND f.duree > 120
```