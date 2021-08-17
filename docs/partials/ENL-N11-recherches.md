# Recherches et sources anglophones

Je privilégie l'anglais pour l'ensemble de mes recherches étant donné qu'il s'agit de la langue de référence pour tout développeur qui se respecte.

On trouve également un bon nombre croissant de ressources francophones.

Le pourcentage reste néanmoins minime comparé au nombre de ressources anglophones.

Certains termes sont aussi difficiles à traduire et à retranscrire de manière exacte dans la langue française.

J'ai traduit une première partie de l'intégration du moteur de templates Twig en me basant sur le chapitre [Twig for Developers](https://twig.symfony.com/doc/3.x/api.html) de la documentation officielle de la version 3.

**<u>Version originale :</u>**

**Twig for Developers**

This chapter describes the API to Twig and not the template language. It will be most useful as reference to those implementing the template interface to the application and not those who are creating Twig templates.

**Basics**

Twig uses a central object called the environment (of class **\Twig\Environment**). Instances of this class are used to store the configuration and extensions, and are used to load templates.

Most applications create one **\Twig\Environment** object on application initialization and use that to load templates. In some cases, it might be useful to have multiple environments side by side, with different configurations.

The typical way to configure Twig to load templates for an application looks roughly like this:

```php
@include twig-config
```

This creates a template environment with a default configuration and a loader that looks up templates in the **/path/to/templates/** directory. Different loaders are available and you can also write your own if you want to load templates from a database or other resources.

*Note*

Notice that the second argument of the environment is an array of options. The **cache** option is a compilation cache directory, where Twig caches the compiled templates to avoid the parsing phase for sub-sequent requests. It is very different from the cache you might want to add for the evaluated templates. For such a need, you can use any available PHP cache library.

**<u>Version traduite</u> :**

**Twig pour les développeurs**

Ce chapitre décrit l'API de Twig et non le moteur de templates.

Il sera plus utile comme référence pour tous ceux qui souhaitent intégrer le moteur de templates à l'application, et non créer les templates au format Twig.

**Les bases**

Twig utilise l'objet central (de la classe **\Twig\Environment**) appellé environnement.

Les instances de cette classe servent à enregistrer la configuration et les extensions, et sont utilisées pour le chargement des templates.

La majorité des applications créént un objet **\Twig\Environment** lors de l'initialisation de l'application et l'utilisent pour le chargement des templates.

Dans certains cas, il pourrait s'avérer utile d'avoir plusieurs environnements voisins, avec des configurations différentes.

Le cas typique de la configuration de Twig pour le chargement des templates d'une application est à peu près similaire à cela :

```php
@include twig-config
```

Cela créé un environnement de templates avec une configuration par défaut et un loader qui récupère les templates du répertoire **/path/to/templates/**.

Différents loaders sont disponibles et on peut aussi écrire le nôtre si on souhaite charger des templates d'une base de données ou d'autres ressources.

*Note*

A noter que le second argument de l'application est un tableau d'options. L'option **cache** est un répertoire de cache de compilation, où Twig met en cache les modèles compilés pour éviter la phase d'analyse syntaxique des requêtes sous-jacentes.

Elle est très différente du cache que l'on souhaiterait ajouter pour les modèles compilés. Afin de satisfaire un tel besoin, toute librairie de cache en PHP s'avère utile.