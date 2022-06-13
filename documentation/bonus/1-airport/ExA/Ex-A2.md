## Ex 2

### 2a)

Requête pour les informations concernant le client

```sql
SELECT c.*
FROM client c, reservation r
WHERE c.id = r.client_id
AND reservation_id = 456789
```

### 2b)

Requête pour les informations concernant le vol aller et retour (n°vol, date + heure départ et arrivée, aéroports, informations de l’avion concerné et classe choisie par le client + prix)

Le montant total de la réservation est calculé ultérieurement.

```sql
SELECT v.id, v.date, v.heure_depart, v.heure_arrivee, a.*, v.classe, r.prix
FROM vol v, aeroport ar, avion av, reservation r
WHERE v.aeroport_id = ar.id
AND v.avion_id = av.id
AND v.reservation_id = r.id
AND r.id = 456789
```