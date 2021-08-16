## Les éléments graphiques de base

**Base** : layout.twig

### Le menu de navigation

**Vue** : partials/navbar.twig

Un menu de navigation du site est visible tout en haut de chaque page et contient :
- le titre English Learner tout à gauche, avec un lien vers la page d'accueil
- les liens des différentes pages à droite dans cet ordre :
    - Inscription (si non connecté)
    - Connexion (si non connecté)
    - l'adresse e-mail d'un utilisateur connecté, avec un lien vers sa page de profil
    - Déconnexion (si connecté)
    - Communauté (liste des utilisateurs)
    - Listes (liste des thèmes)

### Le pied de page

**Vue** : partials/footer.twig

Un pied de page est visible tout en bas de chaque page avec la mention English Learner &copy; 2021 et un lien vers la page des **Mentions Légales**.

### Les messages d'alerte

**Vue** : partials/messages.twig

Les messages d'alerte (ou flash) s'affichent pour valider une action ou notifier une erreur comme :
- la confirmation d'une (dé)connexion
- un champ non valide dans un formulaire
- l'ajout d'un nouveau thème