# La sécurité

Le framework a été conçu pour respecter des principes de sécurité et ainsi éviter certaines failles.

## Les mots de passe

Le mot de passe d'un utilisateur est automatiquement haché selon la méthode **BCrypt** lors de sa création.

```php
@include security/password-hash
```

## La faille XSS (Cross-Site Scripting)

Cette faille permet l'injection de code HTML ou JavaScript dans le champ d'un formulaire pour récupérer des données.

On doit ainsi veiller à transformer les caractères spéciaux, voire à les interdire avant la validation du formulaire, grâce à des expressions régulières et des fonctions natives.

Voici un exemple avec la fonction **clean()** de la classe utilitaire **RandomString** :

```php
@include security/clean-xss
```

## La faille DDoS (Denial of Service Attack)

Une attaque DDoS consiste à envoyer de multiples requêtes sur une même page dans le but d'entraver la capacité d'un site ou d'une application web.

L'intérêt d'une ligne comme `sleep(1);` est de ralentir volontairement un utilisateur malintentionné, en multipliant le nombre de requêtes par 1 000 pour une seconde.

## L'injection SQL

Une injection SQL consiste à modifier une requête envoyée à la base de données pour en détourner l'utilisation et ainsi récupérer des informations, comme le mot de passe d'un administrateur.

Des fonctions natives permettent de protéger les requêtes définies selon des variables.

Voici un extrait de fonction de construction d'une requête :

```php
@include security/injection-sql
```

## La faille CSRF (Cross Site Request Forgery)

Cette faille consiste à voler la session d'un utilisateur pour exécuter des actions à son insu.

On peut ainsi imaginer un utilisateur voler la session d'un administrateur et prendre son rôle.

Le meilleur moyen de s'en prémunir est de gérer l'authentification avec un jeton, aussi appelé **token**.

Ce même jeton est vérifié à chaque modification dans un formulaire.

Voici une illustration en deux fonctions :

```php
@include security/token-csrf
```

<div class="page-break"></div>