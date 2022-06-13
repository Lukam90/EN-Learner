## Ex 6

On admet que la fonction SQL TIMEDIFF(heure1, heure2) calcule la différence HH:MM entre 2 heures, écrire les requêtes SQL qui calculent la durée du trajet aller et retour des vols de la question 2. (sachant que les 2 vols sont rattachés au même numéro de réservation).

```sql
SELECT TIMEDIFF(v.heure_depart, v.heure_arrivee)
FROM vol v, reservation r
WHERE v.reservation_id = r.id
AND r.id = 456789
```