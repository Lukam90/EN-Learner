```sql
CREATE TABLE IF NOT EXISTS matiere (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS professeur (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    nb_heures INTEGER NOT NULL,
    matiere_id INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS classe (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    libelle VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS enseigne (
    professeur_id INTEGER,
    classe_id INTEGER,
    FOREIGN KEY (professeur_id) REFERENCES professeur (id),
    FOREIGN KEY (classe_id) REFERENCES classe (id)
);

CREATE TABLE IF NOT EXISTS principal (
    professeur_id INTEGER,
    classe_id INTEGER,
    FOREIGN KEY (professeur_id) REFERENCES professeur (id),
    FOREIGN KEY (classe_id) REFERENCES classe (id)
);

CREATE TABLE IF NOT EXISTS eleve (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    classe_id INTEGER NOT NULL,
    FOREIGN KEY (classe_id) REFERENCES classe (id)
);

CREATE TABLE IF NOT EXISTS note (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    score INTEGER NOT NULL,
    `date` DATE NOT NULL,
    professeur_id INTEGER NOT NULL,
    eleve_id INTEGER NOT NULL,
    matiere_id INTEGER NOT NULL,
    FOREIGN KEY (professeur_id) REFERENCES professeur (id),
    FOREIGN KEY (eleve_id) REFERENCES eleve (id),
    FOREIGN KEY (matiere_id) REFERENCES matiere (id)
);
```