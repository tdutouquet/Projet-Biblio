# Projet MyBiblio

## Setup

Le projet MyBiblio contient des fixtures, qui permettent de kickstart la base de données, pour plusieurs entités :
* Utilisateurs ;
* Livres ;
* Abonnements (et types d'abonnements) ;
* Equipements et états des salles ;
* Commentaires.

Pour charger les fixtures dans la base de données :

```
symfony console make:migration
```
```
symfony console d:m:m
```
```
symfony console d:f:l
```

Une fois les fixtures chargées, un utilisateur administrateur est créé avec le login `admin@localhost.fr` et le mot de passe `admin`.
