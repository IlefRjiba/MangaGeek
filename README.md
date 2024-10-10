Nom et Prénom: Rjiba Ilef

Ce site web, réalisé par symfony, est une interface qui permet aux collectionneurs de mangas de mettre leurs mangas préférés en valeur, en les partageant avec d'autres utilisateurs, les ajoutant dans leur collections.

Ce site comporte plusieures entités:
* Les mangas. Ils ont un id, nom et auteur.
* L'inventaire, appelé bookshelf dans ce projet. Il a un id et un nom.
* La galerie, appelée mangatheque. Elle a un id.
* L'utilisateur appelé user. Un utilisateur a un id, username, mot de passe (mdp) et email.

Tous les attributs des entités mentionnés sont des string par défaut.

Les routes accessibles dans ce site sont : 
* http://127.0.0.1:8000/mangashelf: liste tous les mangashelfs crées
* http://127.0.0.1:8000/mangashelf/{id}: affiche les informations d'un mangashelf spécifique
* http://127.0.0.1:8000/manga/{id}: affiche les informations d'un manga spécifique