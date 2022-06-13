### 2e)

Donner la programmation du cinéma pour la période du 18/09/2019 au 24/09/2019

```sql
SELECT f.*, sa.*, se.*
FROM film f, salle sa, seance se
WHERE f.salle_id = sa.id
AND se.salle_id = sa.id
AND se.date BETWEEN '2019-09-18' AND '2019-09-24'
```