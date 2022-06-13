### 2d)

Combien de films sont programmés par salle à partir d’aujourd’hui ?

```sql
SELECT sa.id, COUNT(f.id)
FROM salle sa, film f
WHERE f.salle_id = sa.id
GROUP BY sa.id
```