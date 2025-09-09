# Gestion d'une Bibliothèque

Ce repo contient un projet Symfony que j'ai réalisé dans le cadre d'un recrutement en tant qu'alternant chez [Spyrit](https://www.spyrit.net/).

Il s'agit d'une petite application web pour la gestion des livres d'une bibliothèque.


## Lancer le projet :

Si vous avez Make ou NMake: /!\ cela procédera au téléchargement des dépendances /!\

```bash
make start
```
```bash
nmake start
```

Sinon vous pouvez éxécuter les commandes suivantes dans un terminal:

```bash
composer install # pour installer toutes les dépendances Composer
php bin/console doctrine:database:create # Crée la base de données SQLite
php bin/console make:migration --no-interaction # Génère les scripts nécéssaires à la création des tables
php bin/console doctrine:migrations:migrate --no-interaction # Génère les tables
php bin/console doctrine:fixtures:load --no-interaction # Génère des valeurs par défaut
php -S localhost:8000 -t public # Démarre le serveur en local
```


## Stacks techniques

- [PHP](https://www.php.net/) 8.4
- [Composer](https://getcomposer.org/) 2.8
- [Symfony](https://symfony.com/) 7.3
- [SQLite](https://sqlite.org/) 3.4
- [Tailwind](https://tailwindcss.com/) 4.1


## Auteur

Ludovic BERNARD, diplômé d'un BUT Informatique à l'IUT A de Lille.

Le projet a été débuté le 30 août 2025.


## Base de données et entités

Pour que le projet soit "portable" et simple d'utilisation, j'ai décidé d'utiliser SQLite.

Voici les entités du projet:

- 'Subscriber' (Une personne étant abonné à la librairie - qui peut emprunter des livres)

|Colonne|Type|
|-------|----|
|firstname|varchar(255)|
|lastname|varchar(255)|
|email|varchar(255), unique|

- 'Book' (Un livre de la bibliothèque - qu'un abonné peut emprunté si disponible)

|Colonne|Type|
|-------|----|
|title|varchar(255)|
|synopsys|text|
|nb_pages|smallint|
|author|varchar(255)|
|borrower_id|ManyToOne(inversedBy: 'books'), on delete set null|

