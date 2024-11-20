<!-- Nom et Prénom: Rjiba Ilef
## Présentation du site: 

Ce site web appelé MangaGeek et développé en utilisant Symfony et offre une plateforme dynamique dédiée aux passionnés de mangas. Il permet aux utilisateurs de mettre en avant leurs collections de mangas en les partageant avec une communauté d'aficionados similaires. Cette plateforme est non seulement un lieu de partage mais aussi un espace pour découvrir et explorer de nouveaux mangas à travers les collections d'autres membres.

## Structure du site:
Le site est structuré autour des entités principales suivantes :
- **Manga** : Identifié par un ID, chaque manga a un nom, un auteur et une image.
- **Mangashelf** (Inventaire) : Chaque utilisateur peut créer un seul mangashelf, chacun avec un ID et un nom.
- **Mangathèque** (Galerie) : Un espace où les mangas sont exposés. Comporte un ID, une description, et la variable publiee qui inddique s'il est public ou pas. Chaque utilisateur peut créer plusieurs Mangathèques. Un mangathèque n'appartient qu'à un seul utilisateur.
- **Member** : Chaque utilisateur a un ID, username, mot de passe, et email. Il peut avoir l'un des roles suivants: ROLE_ADMIN ou ROLE_USER

Tous les attributs des entités mentionnés sont des string par défaut.

## Fonctionnalités et navigation:
Le site propose des routes web spécifiques pour accéder à différentes fonctionnalités :


**Pour tous les utilisateurs:**
- **page d'accueil** : http://127.0.0.1:8000/
- **Connexion** : http://127.0.0.1:8000/login
- **Déonnexion** : http://127.0.0.1:8000/logout

- **Accueil des Mangas** : http://127.0.0.1:8000/manga affiche la liste des mangas de l'utilisateur.
- **Accueil des Mangatheques de l'utilisateur** : http://127.0.0.1:8000/mangatheque/mine affiche les Mangatheques de l'utilisateur.
- **Listes des Mangatheques** : http://127.0.0.1:8000/mangatheque affiche la liste des Mangatheques publiques des utilisateurs ainsi que celles de l'utilisateur actuel.

- **Détails du compte** : http://127.0.0.1:8000/account/{id} affiche les détails du compte de l'utilisateur.
- **Détails d'un manga** : http://127.0.0.1:8000/manga/{id} affiche les détails d'un mangas spécifique.
- **Détails du Mangashelf** : http://127.0.0.1:8000/mangashelf/{id} affiche le mangashelf de l'utilisateur.
- **Détails de la Mangatheque** : http://127.0.0.1:8000/mangatheque/{id} affiche les détails d'une mangatheque de l'utilisateur.

- **Modification d'un manga** : http://127.0.0.1:8000/manga/{id}/edit met à jour les détails d'un mangas spécifique.
- **Modification d'une mangatheque** : http://127.0.0.1:8000/mangatheque/{id}/edit met à jour les détails d'un mangas spécifique.

- **Ajout d'un manga à un mangashelf** : http://127.0.0.1:8000/manga/new/{id}

**Pour les administrateurs:**
- **Liste des membres** : http://127.0.0.1:8000/member
- **Liste de tous les mangas** : http://127.0.0.1:8000/manga/all
- **Liste de tous les mangashelves** : http://127.0.0.1:8000/mangashelf/all
- **Liste de toutes les mangastheques** : http://127.0.0.1:8000/mangatheque/all 
L'accès à ces liens est possible grace aux boutons qui sont ajoutés à la navbar au cas où l'utilisateur est un administrateur

Si un utilisateur non administrateur essaie d'accéder à ces lien, il aura une erreur qu'il n'est pas autorisé à voir ces pages

Si on accède au site sans etre authentifié, la navbar n'affichera que le bouton login pour se connecter -->

# **Nom et Prénom : Rjiba Ilef**

---

## **Présentation du site :**

**MangaGeek** est une plateforme web dynamique conçue pour les passionnés de mangas, développée avec le framework Symfony. Ce site offre à ses utilisateurs un espace interactif où ils peuvent partager leurs collections de mangas, explorer celles des autres membres, et découvrir de nouveaux chefs-d'œuvre dans une ambiance communautaire.

MangaGeek est bien plus qu’un simple gestionnaire de collections : c’est une véritable communauté pour les amateurs de mangas, où la découverte et le partage sont au cœur de l’expérience.

---

## **Structure du site :**

Le site est organisé autour de quatre entités principales :

- **Manga** : Chaque manga est identifié par un ID et comprend un nom, un auteur, et une image associée.
  
- **Mangashelf** *(Inventaire)* : Chaque utilisateur peut posséder un unique mangashelf identifié par un ID et un nom. Il s’agit d’un espace dédié à la gestion personnelle de leurs mangas.

- **Mangathèque** *(Galerie)* : Une mangathèque est une galerie publique ou privée où un utilisateur peut exposer ses mangas. Elle est définie par un ID, une description, et un attribut *publiee* qui indique si elle est accessible à tous ou non. Chaque utilisateur peut créer plusieurs mangathèques, mais chaque mangathèque appartient à un seul utilisateur.

- **Member** *(Membre)* : Chaque utilisateur dispose d’un compte avec un ID, un nom d'utilisateur, un mot de passe, et une adresse email. Les membres peuvent être assignés à l’un des rôles suivants :
  - **ROLE_USER** : Utilisateur standard.
  - **ROLE_ADMIN** : Administrateur avec des privilèges avancés.

---

## **Fonctionnalités et Navigation :**

### **Pour tous les utilisateurs non authentifiés :**
    Si un visiteur non authentifié accède au site, seuls les liens de connexion seront affichés dans la barre de navigation.
- **Page d’accueil** : `http://127.0.0.1:8000/` - Présente un aperçu des fonctionnalités principales. (Elle est aussi accessible pour les utilisateur authentifiés)
- **Connexion** : `http://127.0.0.1:8000/login` - Permet aux utilisateurs de se connecter à leurs comptes.
### **Pour tous les utilisateurs authentifiés :**
- **Déconnexion** : `http://127.0.0.1:8000/logout` - Déconnecte l’utilisateur de manière sécurisée.

- **Liste des Mangas** : `http://127.0.0.1:8000/manga` - Affiche les mangas associés au compte utilisateur.
- **Mangathèques de l’utilisateur** : `http://127.0.0.1:8000/mangatheque/mine` - Affiche les galeries personnelles de l'utilisateur.
- **Explorer les Mangathèques** : `http://127.0.0.1:8000/mangatheque` - Montre les mangathèques publiques et celles de l'utilisateur actuel.

- **Détails du compte** : `http://127.0.0.1:8000/account/{id}` - Affiche les informations personnelles de l'utilisateur connecté.
- **Détails d’un Manga** : `http://127.0.0.1:8000/manga/{id}` - Affiche les détails d’un manga spécifique.
- **Détails du Mangashelf** : `http://127.0.0.1:8000/mangashelf/{id}` - Montre les informations de l’inventaire utilisateur.
- **Détails d’une Mangathèque** : `http://127.0.0.1:8000/mangatheque/{id}` - Présente les détails d’une mangathèque.

- **Ajout d’un Manga** : `http://127.0.0.1:8000/manga/new/{id}` - Permet d’ajouter un nouveau manga à un mangashelf.
- **Modification de Mangas** : `http://127.0.0.1:8000/manga/{id}/edit` - Permet de modifier les informations d’un manga.
- **Modification d’une Mangathèque** : `http://127.0.0.1:8000/mangatheque/{id}/edit` - Permet de mettre à jour les détails d’une mangathèque.

---

### **Pour les administrateurs uniquement :**
- **Liste des membres** : `http://127.0.0.1:8000/member` - Accès à tous les membres enregistrés.
- **Liste de tous les Mangas** : `http://127.0.0.1:8000/manga/all` - Affiche tous les mangas enregistrés sur le site.
- **Liste de tous les Mangashelves** : `http://127.0.0.1:8000/mangashelf/all` - Accès à tous les inventaires utilisateurs.
- **Liste de toutes les Mangathèques** : `http://127.0.0.1:8000/mangatheque/all` - Accès à toutes les galeries de mangas.


L'accès à ces liens est possible grâce aux boutons qui sont ajoutés à la barre de navigation si l'utilisateur a le rôle administrateur.
    
Si un utilisateur non administrateur tente d'accéder à ces pages, une erreur d'autorisation sera affichée.
