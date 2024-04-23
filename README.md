# Projet MyBiblio

## Project setup

Le projet MyBiblio contient des fixtures pour plusieurs entités, notamment les utilisateurs et les livres.

```
symfony console make:migration
```
```
symfony console d:m:m
```
```
symfony console d:f:l
```

Une fois les fixtures chargées dans la base de données, un utilisateur administrateur est créé avec le login `admin@localhost.fr` et le mot de passe `admin`.
