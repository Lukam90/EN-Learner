# La conception

## L'interface graphique

L'application comporte plusieurs types de pages, à savoir :
- la page d'accueil
- la liste des utilisateurs
- la liste des thèmes
- la liste des expressions d'un thème
- les formulaires des utilisateurs (inscription, connexion, profil)
- les formulaires d'ajout, d'édition et de suppression

En voici quelques aperçus :

### La page d'accueil

![](images/design/page-accueil.png)

### La liste des utilisateurs

![](images/design/liste-users.png)

### La liste des thèmes

![](images/design/liste-themes.png)

### La liste des expressions d'un thème

![](images/design/liste-expressions.png)

## La base de données

La base de données de l'application est définie selon le modèle suivant :

![](images/schemas/ENL-BDD.png)

Elle se résume ainsi en trois tables :

### Les utilisateurs (users)

Un utilisateur publie aucune ou plusieurs thèmes. (0,n)

Un utilisateur publie aucune ou plusieurs expressions. (0,n)

|||
|-|-|
|**id**|l'identifiant d'un utilisateur|
|**username**|le pseudo d'un utilisateur|
|**email**|l'adresse e-mail d'un utilisateur|
|**password**|le mot de passe d'un utilisateur|
|**role**|le rôle d'un utilisateur (user, admin, moderator)|
|**created_at**|la date d'inscription d'un utilisateur (au format JJ/MM/AAAA)|
|**banned**|le statut de bannissement d'un utilisateur|

```sql
@include tables/create-users
```

### Les thèmes

Un thème appartient à un seul utilisateur. (1,1)

Un thème contient aucune ou plusieurs expressions. (0,n)

|||
|-|-|
|**id**|l'identifiant d'un thème|
|**title**|le titre d'un thème|
|**user_id**|l'identifiant d'un utilisateur|

```sql
@include tables/create-themes
```

### Les expressions

Une expression appartient à un seul utilisateur. (1,1)

Une expression est classée dans un seul thème. (1,1)

|||
|-|-|
|**id**|l'identifiant d'une expression|
|**french**|l'expression en français|
|**english**|la traduction en anglais|
|**phonetics**|la transcription phonétique|
|**user_id**|l'identifiant d'un utilisateur|
|**theme_id**|l'identifiant d'un thème|

```sql
@include tables/create-expressions
```