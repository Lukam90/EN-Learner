## Ex 5

Ecrire la requête SQL qui affiche la liste des 10 prochains vols au départ de l’aéroport de Strasbourg SXB (à partir de l’heure courante) triés du plus proche au plus éloigné

```sql
SELECT v.*
FROM vol v, aeroport a
WHERE v.aeroport_id = a.id
AND a.code = 'SBX'
AND v.date = DATE(NOW())
ORDER BY DATE_FORMAT(v.date, '%H') ASC
LIMIT 10
```