# Projet MyBiblio

## Setup

### Base de données

La base de données du projet est, par défaut, `projet_biblio`. Vous pouvez modifier, si besoin, les informations relatives (notamment les accès) à la BDD dans le fichier `.env` à la ligne 28.

Pour créer la base de donnée depuis le projet Symfony :

```
symfony console doctrine:database:create
```

### Fixtures

Le projet MyBiblio contient des fixtures, qui permettent de kickstart la base de données, pour plusieurs entités :
* Utilisateurs
* Livres (et états)
* Salles (et leurs équipements)
* Abonnements (et types d'abonnements)
* Locations de salles
* Commentaires

Pour charger les fixtures dans la base de données :

```
symfony console make:migration
```
```
symfony console doctrine:migration:migrate
```
```
symfony console doctrine:fixtures:load
```
## Accès administrateur

Une fois les fixtures chargées, un utilisateur administrateur est créé avec 
* Login : `admin@localhost.fr`
* Mot de passe `admin`

## Paiement test via Stripe

Dans le cadre du paiement d'un abonnement, le système utilise Stripe. Pour valider un faux paiement, vous pouvez utiliser les informations de carte suivantes :

* Numéro de carte : 4242 4242 4242 4242
* Date d'expiration : (peu importe)
* Code de sécurité : (peu importe)