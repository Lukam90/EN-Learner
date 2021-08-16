# Extraits de code

Voici quelques extraits de code supplémentaires pour détailler certaines parties de l'application :

## public > index.php

Il s'agit de la page de base de l'application.

On y initialise le routeur.

```php
@include index
```

## public > views > layout.twig

Il s'agit de la page de définition de l'interface graphique en Twig.

```html
@include layout
```

## models > Theme.php

Il s'agit de la classe modèle de la table des thèmes, avec une définition des requêtes.

En voici des exemples :

```php
@include model-theme
```

## controllers > HomeController.php

Il s'agit du contrôleur de la page d'accueil, où on définit le nombre d'utilisateurs, de thèmes et d'expressions.

```php
@include home-controller
```