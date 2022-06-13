### 2g)

Insérer le film « The Joker » (122 min – Réalisateur : Todd PHILIPS) et programmer ce film le 09/10/2019 à 20h en salle 1 (le tarif de cette séance est fixé à 12€).

Le film est diffusé en VOSTF et ce n’est pas une avant-première.

```sql
-- Salles

INSERT INTO salle(capacite) VALUES(200);
INSERT INTO salle(capacite) VALUES(200);
INSERT INTO salle(capacite) VALUES(150);
INSERT INTO salle(capacite) VALUES(100);

-- Film

INSERT INTO film(titre, duree, realisateur_id, salle_id) VALUES('The Joker', 122, 1, 1)

-- Séance

INSERT INTO seance(prix, date, horaire, diffusion, avant_premiere, salle_id) VALUES(12, '2019-10-09', '20:00', 'VOSTF', 0, 1);
```