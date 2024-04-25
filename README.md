# Projet MyBiblio

## Setup

Le projet MyBiblio contient des fixtures, qui permettent de kickstart la base de données, pour plusieurs entités :
* Utilisateurs ;
* Livres (et états);
* Salles (et leurs équipements) :
* Abonnements (et types d'abonnements) ;
* Locations de salles ;
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
## Accès administrateur

Une fois les fixtures chargées, un utilisateur administrateur est créé avec le login `admin@localhost.fr` et le mot de passe `admin`.

## Paiement test via Stripe

Dans le cadre du paiement d'un abonnement, le système utilise Stripe. Pour valider un faux paiement, vous pouvez utiliser les informations de carte suivantes :

* Numéro de carte : 4242 4242 4242 4242
* Date d'expiration : (peu importe)
* Code de sécurité : (peu importe)