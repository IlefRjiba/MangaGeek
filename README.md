Nom et Prénom: Rjiba Ilef
## Présentation du site: 

Ce site web appelé MangaGeek et développé en utilisant Symfony offre une plateforme dynamique dédiée aux passionnés de mangas. Il permet aux utilisateurs de mettre en avant leurs collections de mangas en les partageant avec une communauté d'aficionados similaires. Cette plateforme est non seulement un lieu de partage mais aussi un espace pour découvrir et explorer de nouveaux mangas à travers les collections d'autres membres.

## Structure du site:
Le site est structuré autour des entités principales suivantes :
- **Manga** : Identifié par un ID, chaque manga a un nom et un auteur.
- **Mangashelf** (Inventaire) : Chaque utilisateur peut créer plusieurs bookshelves, chacun avec un ID et un nom.
- **Mangathèque** (Galerie) : Un espace où tous les mangas sont exposés, accessible via un ID.
- **Member** : Chaque utilisateur a un ID, username, mot de passe, et email.

Tous les attributs des entités mentionnés sont des string par défaut.

## Fonctionnalités et navigation:
Le site propose des routes web spécifiques pour accéder à différentes fonctionnalités :

- **Accueil des Bookshelves** : http://127.0.0.1:8000/mangashelf affiche la liste de tous les bookshelves.
- **Détails d'un Bookshelf** : http://127.0.0.1:8000/mangashelf/{id} offre une vue détaillée d'un mangashelf spécifique d'identifiant **id**

- **Détails d'un Manga** : http://127.0.0.1:8000/manga/{id} met en avant les détails spécifiques d'un manga d'identifiant **id**

## PS 
Comme vous pouvez voir, le site est encore dans la zone de construction esthétique et pourrait faire peur à un manga d'horreur, mais sera transformé en un reve d'otaku dans le prochain futur :D
