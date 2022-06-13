### 2a)

Liste des films (titre + réalisateur + durée + horaires) diffusés dans la salle 3

```sql
SELECT f.titre, r.*, f.duree, s.horaire
FROM film f, realisateur r, seance se, salle sa
WHERE se.salle_id = sa.id
AND f.salle_id = sa.id
AND f.realisateur_id = r.id
AND sa.id = 3
```