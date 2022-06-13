```sql
CREATE TABLE IF NOT EXISTS salle (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    capacite INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS seance (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    prix FLOAT NOT NULL,
    `date` DATE DEFAULT CURRENT_TIMESTAMP,
    horaire TIME NOT NULL,
    diffusion VARCHAR(10) NOT NULL,
    avant_premiere BOOLEAN NOT NULL,
    salle_id INTEGER NOT NULL,
    FOREIGN KEY (salle_id) REFERENCES salle (id)
);

CREATE TABLE IF NOT EXISTS realisateur (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS film (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(100) NOT NULL,
    duree INTEGER NOT NULL,
    synopsis TEXT,
    realisateur_id INTEGER NOT NULL,
    salle_id INTEGER NOT NULL,
    FOREIGN KEY (realisateur_id) REFERENCES realisateur (id),
    FOREIGN KEY (salle_id) REFERENCES salle (id)
);
```