
# TP2-PromessesDons-HOURI


Il faut avoir installé au préalable
- Git
-	Composer
-	Docker
-	PHP 8 & Symfony

## GIT

Dans votre terminal là où vous voulez déposer le projet:
git clone git@github.com:MONTREUIL-BTS-SIO2/tp2-PromessesDons-Houri.git

## Docker
Vous devez configurez le fichier docker-compose.yml selon votre machine.
Vous devez aussi créer un .env, vous avez pour modèle le .env-example
- docker-compose up -d --build

## Composer
- composer install

## Symfony 
- symfony console d:m:m 
- symfony console d:f:l --no-interaction
- symfony serve
- symfony server:stop (pour stoper le serveur symfony)

## Utilisation du site
#### Une fois arrivé sur le site en tant qu'utilisateur anonyme vous pourrez:
- visualiser les différentes campagnes actives
- créer une promesse de dons pour une campagne choisie
#### En tant qu'utilisateur connecté
(Vous pouvez vous connecter avec le compte mail:admin@mail.com mdp:admin 
, l'un des comptes créés par les fixtures)
- visualiser l'ensemble des campagnes (même les campagnes désactivées)
- visualiser les campagnes ayant le plus de réussite
- visualiser vos dons
- ajouter et modifier une campagne
- modifier un don
- visualiser plus d'informations concernant une campagne choisie,nombre de dons, taux de conversion etc...



