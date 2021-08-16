# L'architecture

Le framework est entièrement personnalisé pour des raisons de maîtrise de code et de mise en pratique du langage PHP et de la programmation orientée objet.

Il se base par ailleurs sur l'architecture **MVC** (Modèle Vue Contrôleur).

## Les couches du modèle MVC

![](images/schemas/resume-MVC.png)

### Le modèle

La couche **Modèle** gère les données de l'application avec des classes, aussi appelées entités.

Son rôle consiste à récupérer les informations dans la base de données, de les organiser et de les assembler pour être traitées par le contrôleur.

Chaque modèle correspond à une table.

Voici un exemple avec le modèle Theme :

```php
@include model-theme
```

### La vue

La couche **Vue** est la partie visible de l'application, affichée côté client ou dans un navigateur.

Le langage de templating utilisé est Twig.

Voici un exemple avec la liste des thèmes :

```php
@include view-themes
```

### Le contrôleur

La couche **Contrôleur** permet de faire le lien entre la **vue** et le **modèle**, avec l'aide du **routeur**.

Le routeur gère une route existante avec des paramètres validés, et appelle ensuite la fonction correspondante du contrôleur.

Cette partie est le coeur du code et de la logique de l'application.

Voici un exemple pour l'affichage de la page d'accueil :

```php
@include controller-home
```

## La structure du framework

Le framework se divise en plusieurs dossiers :
- controllers
- core
- database
- models
- public
- tests

### Le dossier controllers

Il regroupe les contrôleurs du framework.

|||
|-|-|
|**HomeController.php**|la redirection vers la page d'accueil|
|**NotFoundController.php**|la redirection vers la page d'erreur 404 (adresse invalide)|
|**ThemeController.php**|la gestion des thèmes|
|**UserController.php**|la gestion des utilisateurs|

### Le dossier core

Il regroupe le coeur du fonctionnement du framework avec des classes et des fonctions utilitaires.

|||
|-|-|
|**Controller.php**|la classe de base des contrôleurs|
|**Cookie.php**|la classe utilitaire des cookies|
|**Database.php**|la classe utilitaire de l'objet **PDO** (**PHP D**ata **O**bject) pour la connexion à la base de données|
|**Get.php**|la classe utilitaire de la méthode **GET**|
|**Model.php**|la classe de base des modèles|
|**Post.php**|la classe utilitaire de la méthode **POST**|
|**RandomString.php**|la classe utilitaire des chaînes de caractères aléatoires pour les tokens CSRF et les tests|
|**Router.php**|la classe utilitaire du routeur|
|**Session.php**|la classe utilitaire de la session|
|**Validator.php**|la classe utilitaire de la validation des formulaires|

Les classes utilitaires se basent sur des méthodes statiques.

```php
$fakeUsername = RandomString::fakeString(15);
```

### Le dossier database

Il regroupe un ensemble de fichiers CSV pour remplir la base de données avec des valeurs de test et le script **seeder.php**.

### Le dossier model

Il regroupe les modèles.

|||
|-|-|
|**Expression.php**|la classe modèle de la table des expressions|
|**Theme.php**|la classe modèle de la table des thèmes|
|**User.php**|la classe modèle de la table des utilisateurs|

### Le dossier public

Il regroupe le fichier de base **index.php** suivi de l'ensemble des vues au format Twig, des images, des feuilles de style CSS et des scripts JS.

### Le dossier public/views

Ce dossier regroupe l'ensemble des vues avec les pages de base :

|||
|-|-|
|**layout.twig**|le modèle de base de l'interface graphique|
|**home.twig**|la page d'accueil|

On retrouve ensuite les dossiers suivants :

|||
|-|-|
|**errors**|les pages d'erreur (404)|
|**expressions**|les pages des expressions (ajout, édition et suppression)|
|**partials**|les composants récurrents (barre de navigation, pied de page, messages flash)|
|**themes**|les pages des thèmes|
|**users**|les pages des utilisateurs|

### Le dossier tests

Il regroupe l'ensemble des classes de tests automatisés.

|||
|-|-|
|**ExpressionTest.php**|tests des fonctions liées à la table des expressions|
|**ThemeTest.php**|tests des fonctions liées à la table des thèmes|
|**UserTest.php**|tests des fonctions liées à la table des utilisateurs|

<div class="page-break"></div>