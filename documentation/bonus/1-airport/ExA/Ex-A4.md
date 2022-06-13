## Ex 4

Ecrire la requête SQL qui permet de savoir combien de vols sont prévus via la compagnie aérienne EasyJet durant le mois de septembre

```sql
SELECT COUNT(v.id)
FROM vol v, avion a
WHERE v.avion = a.id
AND a.compagnie = 'EasyJet'
AND MONTH(v.date) = 9
```