ToDoList
========

Base du projet #8 : Améliorez un projet existant

https://openclassrooms.com/projects/ameliorer-un-projet-existant-1

Composer : 

composer require phpunit/phpunit

Lancer les test :  vendor/bin/phpunit ,  vendor/bin/phpunit tests/AppBundle/Controller/DefaultControllerTest.php

# Projet ToDoList

Ce projet fait partie du défi "Améliorez un Projet Existant" d'OpenClassrooms.
Lien vers le défi : [Défi Améliorez un Projet Existant](https://openclassrooms.com/projects/ameliorer-un-projet-existant-1)

## Prérequis

Avant de commencer, assurez-vous d'avoir installé les éléments suivants :

- [Composer](https://getcomposer.org/) : Gestionnaire de dépendances pour PHP.

## Installation

1. Clonez ce dépôt vers votre machine locale :

    ```bash
    git clone https://github.com/ERRECADE/errecade_alexandre_projet_8.git
    ```

2. Accédez au répertoire du projet :

    ```bash
    cd ToDoList
    ```

3. Installez les dépendances du projet à l'aide de Composer :

    ```bash
    composer install
    ```

## Configuration de la Base de Données

1. Créez une copie du fichier `.env` et configurez-le avec vos informations de base de données :

    ```bash
    cp .env .env.test
    ```
2. Créez la base de données :

    ```bash
    php bin/console doctrine:database:create
    ```

## Migrations

1. Générez les migrations basées sur les entités :

    ```bash
    php bin/console make:migration
    ```

2. Appliquez les migrations pour mettre à jour la base de données :

    ```bash
    php bin/console doctrine:migrations:migrate
    ```

## Fixtures

Chargez des données de test dans la base de données :

```bash
php bin/console doctrine:fixtures:load
 ```


## Test
1. installez phpunit : 
 
 ```bash
composer require phpunit/phpunit
```
2. lancez les test 

```bash
vendor/bin/phpunit
```
vous pouvez aussi seulement un controller de test 
```bash
vendor/bin/phpunit tests/AppBundle/Controller/TaskControllerTest.php
```