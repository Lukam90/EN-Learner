# English Learner - MCD

## Les tables

Les tables sont les structures d'enregistrement de la base de données de notre application.

### user

Cette table regroupe l'ensemble des utilisateurs.
- **id** (int) : l'identifiant d'un utilisateur
- username (string, 50) : le pseudo d'un utilisateur, unique, de 3 à 50 caractères alphanumériques, espaces inclus
- email (string, 100) : l'adresse e-mail d'un utilisateur, unique
- password (string) : le mot de passe d'un utilisateur (haché au format Argon2i), de 8 à 32 caractères incluant minuscules, majuscules et chiffres
- roles (json) : le rôle d'un utilisateur (membre, modérateur, administrateur), défini en format JSON selon Symfony
- createdAt (datetime) : la date d'inscription d'un utilisateur, déterminée à sa création
- banned (boolean) : le bannissement d'un utilisateur par un administrateur

### expression

Cette table regroupe l'ensemble des expressions (mots et phrases).
- **id** (int) : l'identifiant de l'expression
- french (string, 255) : l'expression en français
- english (string, 255) : la traduction en anglais
- phonetics (string, 255) : la transcription phonétique
- valid (boolean) : expression validée (ou non) par un administrateur ou un modérateur

### theme

Cette table regroupe l'ensemble des thèmes.
- **id** (int) : l'identifiant d'un thème
- title (string, 255) : le titre d'un thème, unique
- valid (boolean) : thème validé (ou non) par un administrateur ou un modérateur

## Les relations

Les relations entre les tables comme décrites dans le MCD résument le fonctionnement de notre application.

### user / expression

**user -> expression**

Un utilisateur peut suggérer aucune ou plusieurs expressions. (0,n)

La suppression d'un utilisateur entraîne la suppression de l'ensemble de ses expressions.

$expressions (User, OneToMany, nullable)

**expression -> user**

Une expression est suggérée par un seul utilisateur et lui appartient. (1,1)

$user (Expression, OneToOne)

### expression / theme

**expression -> theme**

Une expression est classée selon un thème précis. (1,1)

$theme (Expression, OneToOne)

**theme -> expression**

Un thème peut classer aucune ou plusieurs expressions. (0,n)

La suppression d'un thème entraîne la suppression de ses expressions.

$expressions (Theme, OneToMany, nullable)

### user / theme

**user -> theme**

Un utilisateur peut suggérer un ou plusieurs thèmes. (0,n)

La suppression d'un utilisateur entraîne la suppression de l'ensemble de ses thèmes.

$themes (User, OneToMany, nullable)

**theme -> user**

Un thème est suggéré par un seul utilisateur et lui appartient. (1,1)

$user (Theme, OneToOne)