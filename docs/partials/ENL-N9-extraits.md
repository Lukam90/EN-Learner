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

## core > Router.php

Il s'agit de la classe du routeur pour gérer les redirections d'une manière générale.

```php
@include router
```

## core > Session.php

Il s'agit de la classe des sessions liée à la superglobale `$_SESSION`.

```php
@include session
```

## validation > UserValidation.php

Il s'agit de la classe de validation liée aux pages des utilisateurs.

```php
@include user-validation
```

<div class="page-break"></div>