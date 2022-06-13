## Ex 3

Ecrire la requête SQL qui permet de savoir combien de passagers ont réservé le vol aller ci-dessus.

Dans une 2e requête, lister la liste des passagers (nom, prénom) de ce vol triés par nom de famille de A à Z.

Dans une 3e requête, lister ces mêmes passagers mais uniquement ceux dont le nom de famille termine par la particule "LAN".

```sql
SELECT COUNT(c.id)
FROM client c, vol v, reservation r
WHERE v.reservation_id = r.id
AND r.client_id = c.id
AND v.id = 4800;

SELECT c.nom, c.prenom
FROM client c, vol v, reservation r
WHERE v.reservation_id = r.id
AND r.client_id = c.id
AND v.id = 4800
ORDER BY c.nom ASC;

SELECT c.nom, c.prenom
FROM client c, vol v, reservation r
WHERE v.reservation_id = r.id
AND r.client_id = c.id
AND v.id = 4800
AND c.nom LIKE '%LAN';
```